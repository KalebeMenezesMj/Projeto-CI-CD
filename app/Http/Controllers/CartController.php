<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private function getCart()
    {
        if (auth()->check()) {
            return Cart::firstOrCreate(['user_id' => auth()->id()]);
        }

        $sessionId = session()->getId();
        return Cart::firstOrCreate(['session_id' => $sessionId, 'user_id' => null]);
    }

    public function index()
    {
        $cart = $this->getCart();
        $cart->load('items.product.category');
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        $product = Product::findOrFail($request->product_id);

        if (!$product->active || $product->stock < $request->quantity) {
            return back()->with('error', 'Produto indisponível ou estoque insuficiente.');
        }

        $cart = $this->getCart();
        $price = $product->current_price;

        $item = $cart->items()->where('product_id', $product->id)->first();

        if ($item) {
            $newQty = $item->quantity + $request->quantity;
            if ($newQty > $product->stock) {
                return back()->with('error', 'Quantidade solicitada excede o estoque disponível.');
            }
            $item->update(['quantity' => $newQty]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $price,
            ]);
        }

        return back()->with('success', "\"" . $product->name . "\" adicionado ao carrinho!");
    }

    public function update(Request $request, CartItem $item)
    {
        $request->validate(['quantity' => 'required|integer|min:1|max:99']);

        $cart = $this->getCart();
        if ($item->cart_id !== $cart->id) {
            abort(403);
        }

        if ($request->quantity > $item->product->stock) {
            return back()->with('error', 'Quantidade solicitada excede o estoque disponível.');
        }

        $item->update(['quantity' => $request->quantity]);
        return back()->with('success', 'Carrinho atualizado.');
    }

    public function remove(CartItem $item)
    {
        $cart = $this->getCart();
        if ($item->cart_id !== $cart->id) {
            abort(403);
        }

        $item->delete();
        return back()->with('success', 'Item removido do carrinho.');
    }

    public function clear()
    {
        $cart = $this->getCart();
        $cart->items()->delete();
        return back()->with('success', 'Carrinho esvaziado.');
    }

    public static function mergeSessionCart($userId)
    {
        $sessionId = session()->getId();
        $sessionCart = Cart::where('session_id', $sessionId)->where('user_id', null)->first();

        if (!$sessionCart || $sessionCart->items()->count() === 0) {
            return;
        }

        $userCart = Cart::firstOrCreate(['user_id' => $userId]);

        foreach ($sessionCart->items as $item) {
            $existing = $userCart->items()->where('product_id', $item->product_id)->first();
            if ($existing) {
                $existing->increment('quantity', $item->quantity);
            } else {
                $userCart->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);
            }
        }

        $sessionCart->delete();
    }
}
