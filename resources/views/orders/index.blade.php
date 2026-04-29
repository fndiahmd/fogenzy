@extends('layouts.app')
@section('title', 'Pesanan Saya — FOGENZY')

@section('content')
<div class="container-fluid px-4 px-md-5 py-5">
    <div style="max-width:900px;margin:0 auto;">
        <div style="margin-bottom:3rem;">
            <p style="font-size:0.6rem;letter-spacing:0.25em;text-transform:uppercase;color:var(--accent);margin-bottom:0.5rem;">Akun</p>
            <h1 style="font-family:var(--font-display);font-weight:300;font-size:2.5rem;">Pesanan Saya</h1>
        </div>

        @if($orders->isEmpty())
            <div style="text-align:center;padding:6rem 0;">
                <div style="width:64px;height:64px;border:1px solid var(--border);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;">
                    <i class="bi bi-bag" style="font-size:1.5rem;color:#ccc;"></i>
                </div>
                <p style="font-family:var(--font-display);font-size:1.75rem;font-weight:300;color:#ccc;margin-bottom:0.75rem;">Belum ada pesanan</p>
                <p style="font-size:0.78rem;color:var(--muted);margin-bottom:2rem;">Mulai belanja dan temukan koleksi terbaru FOGENZY</p>
                <a href="{{ route('products.index') }}" class="btn-noir">Mulai Belanja</a>
            </div>
        @else
            <!-- STATUS FILTER TABS -->
            <div style="display:flex;gap:0;border-bottom:1px solid var(--border);margin-bottom:2rem;overflow-x:auto;">
                @foreach(['all' => 'Semua', 'pending' => 'Pending', 'processing' => 'Diproses', 'shipped' => 'Dikirim', 'completed' => 'Selesai'] as $val => $label)
                <a href="{{ route('orders.index', $val !== 'all' ? ['status' => $val] : []) }}"
                    style="padding:0.75rem 1.25rem;font-size:0.65rem;letter-spacing:0.12em;text-transform:uppercase;text-decoration:none;white-space:nowrap;border-bottom:2px solid transparent;margin-bottom:-1px;transition:all 0.2s;
                    {{ (request('status') == $val || ($val == 'all' && !request('status'))) ? 'color:var(--noir);border-bottom-color:var(--noir);' : 'color:var(--muted);' }}">
                    {{ $label }}
                </a>
                @endforeach
            </div>

            <!-- ORDER LIST -->
            <div style="display:flex;flex-direction:column;gap:1rem;">
                @foreach($orders as $order)
                <div style="border:1px solid var(--border);padding:1.5rem;transition:border-color 0.2s;" onmouseover="this.style.borderColor='var(--noir)'" onmouseout="this.style.borderColor='var(--border)'">
                    <!-- ORDER HEADER -->
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:0.75rem;margin-bottom:1.25rem;padding-bottom:1.25rem;border-bottom:1px solid #f0f0f0;">
                        <div>
                            <p style="font-size:0.62rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--muted);margin-bottom:0.25rem;">No. Order</p>
                            <p style="font-size:0.9rem;font-weight:500;letter-spacing:0.04em;">{{ $order->order_number }}</p>
                        </div>
                        <div>
                            <p style="font-size:0.62rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--muted);margin-bottom:0.25rem;">Tanggal</p>
                            <p style="font-size:0.82rem;">{{ $order->created_at->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p style="font-size:0.62rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--muted);margin-bottom:0.25rem;">Pembayaran</p>
                            <p style="font-size:0.82rem;">{{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</p>
                        </div>
                        <div style="text-align:right;">
                            <p style="font-size:0.62rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--muted);margin-bottom:0.25rem;">Status</p>
                            <span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                        </div>
                    </div>

                    <!-- ORDER ITEMS PREVIEW -->
                    <div style="display:flex;gap:0.75rem;margin-bottom:1.25rem;flex-wrap:wrap;">
                        @foreach($order->items->take(4) as $item)
                        <div style="width:60px;height:80px;background:#f5f5f5;overflow:hidden;flex-shrink:0;" title="{{ $item->product?->name }}">
                            @if($item->product?->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" style="width:100%;height:100%;object-fit:cover;" alt="{{ $item->product->name }}">
                            @else
                                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;">
                                    <span style="font-family:var(--font-display);font-size:1.25rem;color:#ccc;">{{ strtoupper(substr($item->product?->name ?? '?', 0, 1)) }}</span>
                                </div>
                            @endif
                        </div>
                        @endforeach
                        @if($order->items->count() > 4)
                        <div style="width:60px;height:80px;background:#f5f5f5;display:flex;align-items:center;justify-content:center;">
                            <span style="font-size:0.72rem;color:var(--muted);">+{{ $order->items->count() - 4 }}</span>
                        </div>
                        @endif
                    </div>

                    <!-- ORDER FOOTER -->
                    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.75rem;">
                        <div>
                            <span style="font-size:0.72rem;color:var(--muted);">{{ $order->items->sum('quantity') }} item</span>
                            <span style="margin:0 0.5rem;color:var(--border);">·</span>
                            <span style="font-family:var(--font-display);font-size:1.1rem;font-weight:600;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('orders.show', $order) }}" class="btn-outline-noir" style="padding:0.5rem 1.25rem;font-size:0.65rem;">
                            Lihat Detail
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- PAGINATION -->
            <div style="margin-top:3rem;display:flex;justify-content:center;">
                {{ $orders->withQueryString()->links('vendor.pagination.bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection
