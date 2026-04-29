<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $carts = auth()->user()->carts()->with('product')->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        $total = $carts->sum(fn($c) => $c->product->price * $c->quantity);

        return view('checkout.index', compact('carts', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'phone'             => 'required|string|max:20',
            'address'           => 'required|string',
            'city'              => 'required|string|max:100',
            'postal_code'       => 'required|string|max:10',
            'payment_method'    => 'required|in:transfer_bank,cod,e_wallet',
            'notes'             => 'nullable|string',
        ]);

        $carts = auth()->user()->carts()->with('product')->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        // Check stock
        foreach ($carts as $cart) {
            if ($cart->product->stock < $cart->quantity) {
                return back()->with('error', "Stok {$cart->product->name} tidak mencukupi.");
            }
        }

        $total = $carts->sum(fn($c) => $c->product->price * $c->quantity);

        $shippingAddress = implode(', ', [
            $request->name,
            $request->phone,
            $request->address,
            $request->city,
            $request->postal_code,
        ]);

        $order = Order::create([
            'user_id'          => auth()->id(),
            'order_number'     => 'NV-' . strtoupper(Str::random(8)),
            'status'           => 'pending',
            'total_amount'     => $total,
            'shipping_address' => $shippingAddress,
            'payment_method'   => $request->payment_method,
            'notes'            => $request->notes,
        ]);

        foreach ($carts as $cart) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $cart->product_id,
                'quantity'   => $cart->quantity,
                'price'      => $cart->product->price,
            ]);

            // Reduce stock
            $cart->product->decrement('stock', $cart->quantity);
        }

        // Clear cart
        auth()->user()->carts()->delete();

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order berhasil! Nomor order: ' . $order->order_number);
    }
}
