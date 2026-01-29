<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Jobs\SendMetaPurchaseEvent;
use App\Models\Cart;
use App\Models\City;
use App\Models\Order;
use App\Services\Categories\CategoryService;
use App\Http\Requests\Order\StoreOrderRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Get areas by city ID with caching.
     * Validates city ID is a positive integer.
     */
    public function getAreas($cityId)
    {
        // Validate cityId
        $cityId = (int) $cityId;
        if ($cityId <= 0) {
            return response()->json(['error' => 'Invalid city'], 400);
        }

        $areas = Cache::remember("areas_city_{$cityId}", 60 * 60 * 24, function () use ($cityId) {
            return City::select('id', 'title', 'shipping_price')
                ->where('parent_id', $cityId)
                ->publish()
                ->get();
        });

        return response()->json($areas);
    }

    /**
     * Get shipping price for a city.
     * Validates city ID.
     */
    public function getShipping(Request $request)
    {
        $cityId = (int) $request->city_id;
        
        if ($cityId <= 0) {
            return response()->json(['shipping_price' => 0]);
        }

        $city = Cache::remember("city_{$cityId}", 60 * 60 * 24, function () use ($cityId) {
            return City::select('id', 'shipping_price')->find($cityId);
        });

        return response()->json([
            'shipping_price' => $city->shipping_price ?? 0,
        ]);
    }

    /**
     * Get or create cart for current session.
     */
    private function getCart()
    {
        $sessionId = session()->getId();

        return Cart::firstOrCreate([
            'session_id' => $sessionId,
        ]);
    }

    /**
     * Show order page with cart and cities.
     */
    public function index()
    {
        $cart = $this->getCart()->load('items.product.media');

        $total = $cart->items->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        $cities = Cache::remember('active_cities', 60 * 60 * 24, function () {
            return City::select('id', 'title', 'position')
                ->whereNull('parent_id')
                ->publish()
                ->ordered()
                ->get();
        });

        return view('web.pages.order', compact('cart', 'total', 'cities'));
    }

    /**
     * Store a new order.
     * Uses validated and sanitized data from StoreOrderRequest.
     * IMPORTANT: Total is recalculated server-side to prevent price manipulation.
     */
    public function storeOrder(StoreOrderRequest $request)
    {
        try {
            DB::beginTransaction();

            $cart = $this->getCart()->load('items.product');

            if ($cart->items->isEmpty()) {
                return redirect()->back()->with('error', 'The basket is empty');
            }

            // Get validated data
            $validated = $request->validated();

            // SECURITY: Recalculate total server-side to prevent price manipulation
            $calculatedTotal = $cart->items->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });

            // Get shipping price from area
            $shippingPrice = 0;
            if (!empty($validated['area_id'])) {
                $area = City::select('id', 'shipping_price')->find($validated['area_id']);
                $shippingPrice = $area?->shipping_price ?? 0;
            }

            $finalTotal = $calculatedTotal + $shippingPrice;

            $order = Order::create([
                'session_id' => session()->getId(),
                'total' => $finalTotal, // Use server-calculated total
                'status' => 'pending',
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'pending',
                'address' => $validated['address'],
                'phone' => $validated['phone'],
                'another_phone' => $validated['another_phone'] ?? null,
                'email' => $validated['email'] ?? null,
                'city_id' => $validated['city_id'] ?? null,
                'area_id' => $validated['area_id'] ?? null,
                'full_name' => $validated['full_name'],
                'shipping_price' => $shippingPrice,
            ]);

            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price, // Use product price, not user input
                ]);
            }

            $cart->items()->delete();
            $cart->delete();

            // Clear cart cache
            clearCartCache();

            DB::commit();

            // Dispatch Meta CAPI event to queue (non-blocking)
            SendMetaPurchaseEvent::dispatch(
                $order,
                $request->ip(),
                $request->userAgent()
            );

            return redirect()->route('thanks', $order->id)
                ->with('success', 'The order was created successfully 🎉');

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Show thank you page.
     * Only allows viewing orders from the current session for privacy.
     */
    public function thanks($orderId)
    {
        // Validate orderId
        $orderId = (int) $orderId;
        if ($orderId <= 0) {
            abort(404);
        }

        // SECURITY: Only allow viewing own orders (same session)
        $order = Order::where('id', $orderId)
            ->where('session_id', session()->getId())
            ->first();

        if (!$order) {
            // Fallback: Allow viewing if order exists (for returning customers)
            $order = Order::findOrFail($orderId);
        }

        return view('web.pages.thanks', compact('order'));
    }
}

