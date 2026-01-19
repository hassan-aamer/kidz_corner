<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Jobs\SendMetaPurchaseEvent;
use App\Models\Cart;
use App\Models\City;
use App\Models\Order;
use App\Services\Categories\CategoryService;
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
     */
    public function getAreas($cityId)
    {
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
     */
    public function getShipping(Request $request)
    {
        $cityId = $request->city_id;

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
     */
    public function storeOrder(Request $request)
    {
        try {
            DB::beginTransaction();

            $cart = $this->getCart()->load('items.product');

            if ($cart->items->isEmpty()) {
                return redirect()->back()->with('error', 'The basket is empty');
            }

            $area = City::select('id', 'shipping_price')->find($request->area_id);

            $order = Order::create([
                'session_id' => session()->getId(),
                'total' => $request->total,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'address' => $request->address,
                'phone' => $request->phone,
                'another_phone' => $request->another_phone ?? null,
                'email' => $request->email ?? null,
                'city_id' => $request->city_id,
                'area_id' => $request->area_id,
                'full_name' => $request->full_name,
                'shipping_price' => $area?->shipping_price ?? 0,
            ]);

            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
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
     */
    public function thanks($orderId)
    {
        $order = Order::findOrFail($orderId);

        return view('web.pages.thanks', compact('order'));
    }
}
