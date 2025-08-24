<?php

namespace App\Http\Controllers\Web;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Categories\CategoryService;

class OrderController extends Controller
{
    protected CategoryService $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
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
        return view('web.pages.order', compact('cart', 'total'));
    }
    public function storeOrder(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'The basket is empty');
        }

        $order = Order::create([
            'session_id'  => session()->getId(),
            'total'       => collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']),
            'status'      => 'pending',
            'payment_method' => $request->payment_method ?? 'cash',
            'address'     => $request->address,
            'phone'       => $request->phone,
            'email'      => $request->email,
            'city_id'      => $request->city_id,
        ]);

        foreach ($cart as $productId => $item) {
            $order->items()->create([
                'product_id' => $productId,
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
            ]);
        }

        session()->forget('cart');

        return redirect()->route('home', $order->id)
            ->with('success', 'The order was created successfully 🎉');
    }
}
