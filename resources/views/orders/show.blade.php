@extends('layouts.app')
@section('title', 'Order ' . $order->order_number . ' — FOGENZY')

@section('content')
<div class="container-fluid px-4 px-md-5 py-5">
    <div style="max-width:800px;margin:0 auto;">
        <!-- ORDER CONFIRMED HEADER -->
        @if(session('success'))
        <div style="text-align:center;padding:3rem 0 2rem;">
            <div style="width:56px;height:56px;border-radius:50%;border:2px solid #2d6a4f;display:flex;align-items:center;justify-content:center;margin:0 auto 1.25rem;">
                <i class="bi bi-check-lg" style="font-size:1.5rem;color:#2d6a4f;"></i>
            </div>
            <h1 style="font-family:var(--font-display);font-weight:300;font-size:2.5rem;margin-bottom:0.5rem;">Pesanan Dikonfirmasi</h1>
            <p style="font-size:0.78rem;color:var(--muted);">Terima kasih telah berbelanja di FOGENZY</p>
        </div>
        @else
        <div class="mb-4">
            <a href="{{ route('orders.index') }}" style="font-size:0.65rem;letter-spacing:0.12em;text-transform:uppercase;color:var(--muted);text-decoration:none;">← Kembali ke Orders</a>
        </div>
        @endif

        <div style="background:#f8f8f6;padding:1.5rem 2rem;margin-bottom:2rem;display:flex;gap:3rem;flex-wrap:wrap;">
            <div>
                <p style="font-size:0.58rem;letter-spacing:0.18em;text-transform:uppercase;color:var(--muted);margin-bottom:0.25rem;">No. Order</p>
                <p style="font-size:0.9rem;font-weight:500;">{{ $order->order_number }}</p>
            </div>
            <div>
                <p style="font-size:0.58rem;letter-spacing:0.18em;text-transform:uppercase;color:var(--muted);margin-bottom:0.25rem;">Status</p>
                <span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
            </div>
            <div>
                <p style="font-size:0.58rem;letter-spacing:0.18em;text-transform:uppercase;color:var(--muted);margin-bottom:0.25rem;">Tanggal</p>
                <p style="font-size:0.82rem;">{{ $order->created_at->format('d F Y, H:i') }}</p>
            </div>
            <div>
                <p style="font-size:0.58rem;letter-spacing:0.18em;text-transform:uppercase;color:var(--muted);margin-bottom:0.25rem;">Pembayaran</p>
                <p style="font-size:0.82rem;">{{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</p>
            </div>
        </div>

        <div style="margin-bottom:2rem;">
            <p style="font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--muted);margin-bottom:1.25rem;">Item Pesanan</p>
            @foreach($order->items as $item)
            <div style="display:flex;justify-content:space-between;align-items:flex-start;padding:1rem 0;border-bottom:1px solid var(--border);">
                <div style="display:flex;gap:1rem;align-items:flex-start;">
                    <div style="width:60px;height:80px;background:#f5f5f5;overflow:hidden;flex-shrink:0;">
                        @if($item->product?->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}" style="width:100%;height:100%;object-fit:cover;" alt="">
                        @endif
                    </div>
                    <div>
                        <p style="font-size:0.8rem;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.2rem;">{{ $item->product?->name ?? 'Produk Dihapus' }}</p>
                        <p style="font-size:0.72rem;color:var(--muted);">Qty: {{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                    </div>
                </div>
                <p style="font-family:var(--font-display);font-size:1rem;font-weight:600;">
                    Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                </p>
            </div>
            @endforeach
        </div>

        <div style="display:flex;gap:3rem;flex-wrap:wrap;padding-top:1rem;">
            <div style="flex:1;">
                <p style="font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--muted);margin-bottom:0.75rem;">Alamat Pengiriman</p>
                <p style="font-size:0.82rem;line-height:1.7;color:var(--noir);">{{ $order->shipping_address }}</p>
            </div>
            <div style="min-width:200px;text-align:right;">
                <p style="font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--muted);margin-bottom:0.75rem;">Total Pembayaran</p>
                <p style="font-family:var(--font-display);font-size:2rem;font-weight:600;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
            </div>
        </div>

        <div style="margin-top:2.5rem;padding-top:1.5rem;border-top:1px solid var(--border);display:flex;gap:1rem;">
            <a href="{{ route('products.index') }}" class="btn-outline-noir">Lanjut Belanja</a>
            <a href="{{ route('orders.index') }}" class="btn-noir">Semua Pesanan</a>
        </div>
    </div>
</div>
@endsection
