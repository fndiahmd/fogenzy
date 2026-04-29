{{-- ============================================================
     FILE: resources/views/cart/index.blade.php
     ============================================================ --}}
@extends('layouts.app')
@section('title', 'Keranjang — FOGENZY')

@section('content')
<div class="container-fluid px-4 px-md-5 py-5">
    <div class="row">
        <div class="col-12 mb-4">
            <p style="font-size:0.6rem;letter-spacing:0.25em;text-transform:uppercase;color:var(--accent);">FOGENZY</p>
            <h1 style="font-family:var(--font-display);font-weight:300;font-size:2.5rem;">Keranjang Belanja</h1>
        </div>
    </div>

    @if($carts->isEmpty())
        <div style="text-align:center;padding:6rem 0;">
            <p style="font-family:var(--font-display);font-size:2rem;font-weight:300;color:#ccc;">Keranjang Anda kosong</p>
            <p style="font-size:0.78rem;color:var(--muted);margin-bottom:2rem;">Temukan produk pilihan kami di koleksi terbaru</p>
            <a href="{{ route('products.index') }}" class="btn-noir">Mulai Belanja</a>
        </div>
    @else
        <div class="row g-4">
            <!-- CART ITEMS -->
            <div class="col-lg-8">
                @foreach($carts as $cart)
                <div style="display:flex;gap:1.5rem;padding:1.5rem 0;border-bottom:1px solid var(--border);">
                    <!-- Product Image -->
                    <div style="width:100px;height:130px;flex-shrink:0;background:#f5f5f5;overflow:hidden;">
                        @if($cart->product->image)
                            <img src="{{ asset('storage/' . $cart->product->image) }}" alt="{{ $cart->product->name }}" style="width:100%;height:100%;object-fit:cover;">
                        @else
                            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;">
                                <span style="font-family:var(--font-display);font-size:1.5rem;color:#ccc;">{{ strtoupper(substr($cart->product->name,0,1)) }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Product Info -->
                    <div style="flex:1;">
                        <p style="font-size:0.65rem;letter-spacing:0.12em;text-transform:uppercase;color:var(--muted);margin-bottom:0.25rem;">{{ $cart->product->category->name ?? '' }}</p>
                        <p style="font-size:0.9rem;letter-spacing:0.05em;text-transform:uppercase;margin-bottom:0.5rem;">{{ $cart->product->name }}</p>
                        <p style="font-family:var(--font-display);font-size:1.1rem;font-weight:600;margin-bottom:1rem;">Rp {{ number_format($cart->product->price, 0, ',', '.') }}</p>

                        <div style="display:flex;align-items:center;gap:1rem;">
                            <!-- Quantity Form -->
                            <form action="{{ route('cart.update', $cart) }}" method="POST" style="display:flex;align-items:center;gap:0.5rem;">
                                @csrf @method('PATCH')
                                <button type="button" onclick="changeQty(this, -1)" style="width:28px;height:28px;border:1px solid var(--border);background:none;cursor:pointer;font-size:1rem;">−</button>
                                <input type="number" name="quantity" value="{{ $cart->quantity }}" min="1" max="{{ $cart->product->stock }}"
                                    style="width:50px;text-align:center;border:1px solid var(--border);padding:0.25rem;font-family:var(--font-body);font-size:0.85rem;"
                                    id="qty-{{ $cart->id }}">
                                <button type="button" onclick="changeQty(this, 1)" style="width:28px;height:28px;border:1px solid var(--border);background:none;cursor:pointer;font-size:1rem;">+</button>
                                <button type="submit" style="font-size:0.62rem;letter-spacing:0.1em;text-transform:uppercase;border:1px solid var(--noir);background:none;padding:0.3rem 0.75rem;cursor:pointer;">Update</button>
                            </form>

                            <!-- Remove -->
                            <form action="{{ route('cart.remove', $cart) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" style="background:none;border:none;cursor:pointer;font-size:0.65rem;letter-spacing:0.1em;text-transform:uppercase;color:var(--muted);">Hapus</button>
                            </form>
                        </div>
                    </div>

                    <!-- Subtotal -->
                    <div style="text-align:right;min-width:120px;">
                        <p style="font-family:var(--font-display);font-size:1.1rem;font-weight:600;">
                            Rp {{ number_format($cart->product->price * $cart->quantity, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- ORDER SUMMARY -->
            <div class="col-lg-4">
                <div style="background:#f8f8f6;padding:2rem;position:sticky;top:80px;">
                    <p style="font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:1.5rem;">Ringkasan Order</p>

                    <div style="display:flex;justify-content:space-between;margin-bottom:0.75rem;font-size:0.82rem;">
                        <span style="color:var(--muted);">Subtotal ({{ $carts->sum('quantity') }} item)</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;margin-bottom:0.75rem;font-size:0.82rem;">
                        <span style="color:var(--muted);">Pengiriman</span>
                        <span>Dihitung saat checkout</span>
                    </div>

                    <div style="border-top:1px solid var(--border);padding-top:1rem;margin-top:1rem;display:flex;justify-content:space-between;align-items:baseline;">
                        <span style="font-size:0.65rem;letter-spacing:0.12em;text-transform:uppercase;">Total</span>
                        <span style="font-family:var(--font-display);font-size:1.5rem;font-weight:600;">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="btn-noir" style="display:block;text-align:center;margin-top:1.5rem;">Lanjut ke Checkout</a>
                    <a href="{{ route('products.index') }}" class="btn-outline-noir" style="display:block;text-align:center;margin-top:0.75rem;">Lanjut Belanja</a>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
function changeQty(btn, delta) {
    const form = btn.closest('form');
    const input = form.querySelector('input[name="quantity"]');
    const max = parseInt(input.max) || 99;
    let val = parseInt(input.value) + delta;
    if (val < 1) val = 1;
    if (val > max) val = max;
    input.value = val;
}
</script>
@endpush
@endsection
