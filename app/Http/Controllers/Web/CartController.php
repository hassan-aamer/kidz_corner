<?php

namespace App\Http\Controllers\Web;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Categories\CategoryService;
use App\Http\Requests\Cart\AddToCartRequest;
use App\Http\Requests\Cart\UpdateCartRequest;

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

    /**
     * Verify that a cart item belongs to the current session's cart.
     * Prevents manipulation of other users' cart items.
     */
    private function verifyCartItemOwnership(int $itemId): ?CartItem
    {
        $cart = $this->getCart();
        
        return CartItem::where('id', $itemId)
            ->where('cart_id', $cart->id)
            ->first();
    }

    public function index()
    {
        $cart = $this->getCart()->load('items.product.media');

        $total = $cart->items->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        return view('web.pages.cart', compact('cart', 'total'));
    }

    public function add(AddToCartRequest $request, $productId)
    {
        // Validate productId is a valid integer
        $productId = (int) $productId;
        if ($productId <= 0) {
            return redirect()->back()->with('error', 'Invalid product.');
        }

        $cart = $this->getCart();
        
        // Only add active/published products
        $product = Product::publish()->find($productId);
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found or unavailable.');
        }

        $item = CartItem::firstOrCreate([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
        ]);

        $quantity = $request->validated()['quantity'] ?? 1;
        $item->quantity += $quantity;
        
        // Limit total quantity per item
        if ($item->quantity > 100) {
            $item->quantity = 100;
        }
        
        $item->save();

        // Clear cart cache after modification
        clearCartCache();

        return redirect()->back()->with('success', 'The product has been added to the cart ✅');
    }

    public function update(UpdateCartRequest $request, $itemId)
    {
        // Validate itemId is a valid integer
        $itemId = (int) $itemId;
        if ($itemId <= 0) {
            return redirect()->back()->with('error', 'Invalid item.');
        }

        // Verify ownership - only allow updating own cart items
        $item = $this->verifyCartItemOwnership($itemId);
        if (!$item) {
            return redirect()->back()->with('error', 'Item not found.');
        }

        $action = $request->validated()['action'];

        if ($action === 'increment' && $item->quantity < 100) {
            $item->quantity += 1;
        } elseif ($action === 'decrement' && $item->quantity > 1) {
            $item->quantity -= 1;
        }

        $item->save();

        // Clear cart cache after modification
        clearCartCache();

        return redirect()->back()->with('success', 'The quantity has been updated 🔄');
    }

    public function remove($itemId)
    {
        // Validate itemId is a valid integer
        $itemId = (int) $itemId;
        if ($itemId <= 0) {
            return redirect()->back()->with('error', 'Invalid item.');
        }

        // Verify ownership - only allow removing own cart items
        $item = $this->verifyCartItemOwnership($itemId);
        if (!$item) {
            return redirect()->back()->with('error', 'Item not found.');
        }

        $item->delete();

        // Clear cart cache after modification
        clearCartCache();

        return redirect()->back()->with('success', 'The product has been removed from the cart 🗑️');
    }

    public function clear()
    {
        $cart = $this->getCart();
        $cart->items()->delete();

        // Clear cart cache after modification
        clearCartCache();

        return redirect()->back()->with('success', 'The cart has been cleared 🚮');
    }
}

