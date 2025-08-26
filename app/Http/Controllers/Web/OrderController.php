<?php

namespace App\Http\Controllers\Web;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Services\Categories\CategoryService;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected CategoryService $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function getAreas($cityId)
    {
        $areas = City::where('parent_id', $cityId)->get();
        return response()->json($areas);
    }

    public function getShipping(Request $request)
    {
        $cityId = $request->city_id;

        $city = City::find($cityId);

        if ($city) {
            return response()->json([
                'shipping_price' => $city->shipping_price ?? 0
            ]);
        }

        return response()->json([
            'shipping_price' => 0
        ]);
    }

    private function getCart()
    {
        $sessionId = session()->getId();

        return Cart::firstOrCreate([
            'session_id' => $sessionId
        ]);
    }

    public function index()
    {
        $cart = $this->getCart()->load('items.product');

        $total = $cart->items->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        $cities = City::where('parent_id', null)->Publish()->get()->sortBy('position');
        return view('web.pages.order', compact('cart', 'total', 'cities'));
    }
    public function storeOrder(Request $request)
    {
        try {

            DB::beginTransaction();
            $cart = $this->getCart()->load('items.product');

            if (empty($cart)) {
                return redirect()->back()->with('error', 'The basket is empty');
            }

            $area = City::find($request->area_id);

            $order = Order::create([
                'session_id'          => session()->getId(),
                'total'               => $request->total,
                'status'              => 'pending',
                'payment_method'      => $request->payment_method,
                'payment_status'      => 'pending',
                'address'             => $request->address,
                'phone'               => $request->phone,
                'email'               => $request->email,
                'city_id'             => $request->city_id,
                'area_id'             => $request->area_id,
                'full_name'           => $request->full_name,
                'shipping_price'      => $area ? $area->shipping_price : 0,
            ]);

            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->product->price,
                ]);
            }

            $cart->items()->delete();
            $cart->delete();

            DB::commit();

            return redirect()->route('home', $order->id)
                ->with('success', 'The order was created successfully 🎉');
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
