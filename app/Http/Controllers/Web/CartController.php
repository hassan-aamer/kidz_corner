<?php

namespace App\Http\Controllers\Web;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Services\Categories\CategoryService;

class CartController extends Controller
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
        return view('web.pages.cart', compact('cart', 'total'));
    }

    public function add(Request $request, $productId)
    {
        $cart = $this->getCart();
        $product = Product::findOrFail($productId);

        $item = CartItem::firstOrCreate([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
        ]);

        $item->quantity += $request->input('quantity', 1);
        $item->save();

        return redirect()->back()->with('success', 'The product has been added to the cart ✅');
    }


    public function update(Request $request, $itemId)
    {
        $item = CartItem::findOrFail($itemId);

        $action = $request->input('action');

        if ($action === 'increment') {
            $item->quantity += 1;
        } elseif ($action === 'decrement' && $item->quantity > 1) {
            $item->quantity -= 1;
        }

        $item->save();

        return redirect()->back()->with('success', 'The quantity has been updated 🔄');
    }


    public function remove($itemId)
    {
        CartItem::destroy($itemId);
        return redirect()->back()->with('success', 'The product has been removed from the cart 🗑️');
    }

    public function clear()
    {
        $cart = $this->getCart();
        $cart->items()->delete();

        return redirect()->back()->with('success', 'The cart has been cleared 🚮');
    }
}
