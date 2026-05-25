<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function getCart()
    {
        return Cart::where('user_id', auth()->id())->with('items.product')->first();
    }

    public function index()
    {
        $cart = $this->getCart();

        if (! $cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Seu carrinho está vazio.');
        }

        $user = auth()->user();
        $addresses = $user->addresses;
        $defaultAddress = $user->default_address;

        return view('checkout.index', compact('cart', 'user', 'addresses', 'defaultAddress'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_name' => 'required|string|max:100',
            'shipping_phone' => 'required|string|max:20',
            'shipping_zipcode' => 'required|string|max:10',
            'shipping_address' => 'required|string|max:200',
            'shipping_number' => 'required|string|max:20',
            'shipping_complement' => 'nullable|string|max:100',
            'shipping_neighborhood' => 'required|string|max:100',
            'shipping_city' => 'required|string|max:100',
            'shipping_state' => 'required|string|max:2',
            'payment_method' => 'required|in:credit_card,pix,boleto',
            'notes' => 'nullable|string|max:500',
        ]);

        $cart = $this->getCart();

        if (! $cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Seu carrinho está vazio.');
        }

        foreach ($cart->items as $item) {
            if ($item->product->stock < $item->quantity) {
                return back()->with('error', "Estoque insuficiente para \"{$item->product->name}\".");
            }
        }

        DB::transaction(function () use ($request, $cart) {
            $subtotal = $cart->total;
            $shipping = $subtotal >= 150 ? 0 : 15.00;
            $total = $subtotal + $shipping;

            $order = Order::create([
                'user_id' => auth()->id(),
                'code' => Order::generateCode(),
                'status' => Order::STATUS_PENDING,
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'discount' => 0,
                'total' => $total,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'notes' => $request->notes,
                'shipping_name' => $request->shipping_name,
                'shipping_phone' => $request->shipping_phone,
                'shipping_zipcode' => $request->shipping_zipcode,
                'shipping_address' => $request->shipping_address,
                'shipping_number' => $request->shipping_number,
                'shipping_complement' => $request->shipping_complement,
                'shipping_neighborhood' => $request->shipping_neighborhood,
                'shipping_city' => $request->shipping_city,
                'shipping_state' => $request->shipping_state,
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'product_price' => $item->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->subtotal,
                ]);

                $item->product->decrement('stock', $item->quantity);
            }

            $cart->items()->delete();

            session(['last_order_id' => $order->id]);
        });

        return redirect()->route('checkout.success');
    }

    public function success()
    {
        $orderId = session('last_order_id');
        if (! $orderId) {
            return redirect()->route('home');
        }

        $order = Order::with('items')->findOrFail($orderId);

        return view('checkout.success', compact('order'));
    }
}
