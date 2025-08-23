<?php

namespace App\Http\Controllers\Web;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
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
