@extends('layouts.admin')
@section('title', 'Order ' . $order->order_number)
@section('topbar-title', 'Detail Order')

@section('topbar-actions')
    <a href="{{ route('admin.orders.index') }}" class="topbar-btn">← Kembali</a>
@endsection

@section('content')
<div class="page-header">
    <h1>{{ $order->order_number }}</h1>
    <p>Order masuk: {{ $order->created_at->format('d F Y, H:i') }}</p>
</div>

<div class="row g-4">
    <!-- LEFT: ORDER DETAILS -->
    <div class="col-lg-8">

        <!-- ORDER ITEMS -->
        <div style="background:#fff;margin-bottom:1rem;">
            <div style="padding:1.25rem 1.5rem;border-bottom:1px solid #f0f0f0;">
                <p style="font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;margin:0;">Item Pesanan</p>
            </div>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga Satuan</th>
                        <th>Qty</th>
                        <th style="text-align:right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:0.875rem;">
                                <div style="width:48px;height:64px;background:#f5f5f5;overflow:hidden;flex-shrink:0;">
                                    @if($item->product?->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" style="width:100%;height:100%;object-fit:cover;" alt="">
                                    @else
                                        <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;">
                                            <span style="font-family:var(--font-display);font-size:1rem;color:#ccc;">{{ strtoupper(substr($item->product?->name ?? '?', 0, 1)) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p style="font-size:0.82rem;margin:0;font-weight:400;">{{ $item->product?->name ?? 'Produk Dihapus' }}</p>
                                    <p style="font-size:0.68rem;color:var(--muted);margin:0;">{{ $item->product?->category?->name ?? '' }}</p>
                                </div>
                            </div>
                        </td>
                        <td style="font-size:0.8rem;">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td style="font-size:0.8rem;">{{ $item->quantity }}</td>
                        <td style="text-align:right;font-family:var(--font-display);font-weight:600;font-size:0.9rem;">
                            Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align:right;padding:1rem 1.25rem;font-size:0.68rem;letter-spacing:0.12em;text-transform:uppercase;color:var(--muted);">Total</td>
                        <td style="text-align:right;padding:1rem 1.25rem;font-family:var(--font-display);font-size:1.25rem;font-weight:600;border-top:2px solid var(--noir);">
                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- CUSTOMER INFO -->
        <div style="background:#fff;padding:1.5rem;">
            <p style="font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:1.25rem;padding-bottom:0.75rem;border-bottom:1px solid #f0f0f0;">Informasi Pelanggan</p>
            <div class="row g-3">
                <div class="col-md-6">
                    <p style="font-size:0.58rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--muted);margin-bottom:0.25rem;">Nama</p>
                    <p style="font-size:0.85rem;">{{ $order->user->name ?? '—' }}</p>
                </div>
                <div class="col-md-6">
                    <p style="font-size:0.58rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--muted);margin-bottom:0.25rem;">Email</p>
                    <p style="font-size:0.85rem;">{{ $order->user->email ?? '—' }}</p>
                </div>
                <div class="col-12">
                    <p style="font-size:0.58rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--muted);margin-bottom:0.25rem;">Alamat Pengiriman</p>
                    <p style="font-size:0.85rem;line-height:1.7;">{{ $order->shipping_address }}</p>
                </div>
                @if($order->notes)
                <div class="col-12">
                    <p style="font-size:0.58rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--muted);margin-bottom:0.25rem;">Catatan</p>
                    <p style="font-size:0.85rem;font-style:italic;color:var(--muted);">{{ $order->notes }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- RIGHT: STATUS UPDATE -->
    <div class="col-lg-4">
        <!-- CURRENT STATUS -->
        <div style="background:#fff;padding:1.5rem;margin-bottom:1rem;border-top:2px solid var(--{{ $order->status == 'completed' ? 'accent' : 'noir' }});">
            <p style="font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:1rem;">Status Saat Ini</p>
            <span class="status-badge status-{{ $order->status }}" style="font-size:0.72rem;padding:0.4em 0.9em;">
                {{ ucfirst($order->status) }}
            </span>

            <!-- STATUS TIMELINE -->
            <div style="margin-top:1.5rem;">
                @php
                    $statuses = ['pending', 'processing', 'shipped', 'completed'];
                    $currentIdx = array_search($order->status, $statuses);
                @endphp
                @foreach($statuses as $idx => $s)
                <div style="display:flex;align-items:center;gap:0.75rem;padding:0.5rem 0;">
                    <div style="width:24px;height:24px;border-radius:50%;border:2px solid {{ ($currentIdx !== false && $idx <= $currentIdx) ? 'var(--noir)' : '#e0e0e0' }};background:{{ ($currentIdx !== false && $idx <= $currentIdx) ? 'var(--noir)' : 'transparent' }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        @if($currentIdx !== false && $idx <= $currentIdx)
                            <i class="bi bi-check" style="font-size:0.7rem;color:#fff;"></i>
                        @endif
                    </div>
                    <span style="font-size:0.72rem;text-transform:capitalize;color:{{ ($currentIdx !== false && $idx <= $currentIdx) ? 'var(--noir)' : '#ccc' }};letter-spacing:0.06em;">
                        {{ ucfirst($s) }}
                    </span>
                </div>
                @if(!$loop->last)
                    <div style="width:2px;height:16px;background:{{ ($currentIdx !== false && $idx < $currentIdx) ? 'var(--noir)' : '#e0e0e0' }};margin-left:11px;"></div>
                @endif
                @endforeach
            </div>
        </div>

        <!-- UPDATE STATUS FORM -->
        @if($order->status !== 'cancelled' && $order->status !== 'completed')
        <div style="background:#fff;padding:1.5rem;margin-bottom:1rem;">
            <p style="font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:1rem;">Update Status</p>
            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                @csrf @method('PATCH')
                <select name="status" class="form-select" style="margin-bottom:0.875rem;">
                    @foreach(['pending','processing','shipped','completed','cancelled'] as $s)
                        <option value="{{ $s }}" {{ $order->status == $s ? 'selected' : '' }}>
                            {{ ucfirst($s) }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="topbar-btn accent" style="width:100%;padding:0.75rem;">
                    Perbarui Status
                </button>
            </form>
        </div>
        @endif

        <!-- ORDER META -->
        <div style="background:#f8f8f6;padding:1.5rem;">
            <p style="font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:1rem;">Ringkasan Order</p>
            <div style="display:flex;flex-direction:column;gap:0.625rem;">
                <div style="display:flex;justify-content:space-between;font-size:0.78rem;">
                    <span style="color:var(--muted);">Metode Pembayaran</span>
                    <span>{{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:0.78rem;">
                    <span style="color:var(--muted);">Jumlah Item</span>
                    <span>{{ $order->items->sum('quantity') }} pcs</span>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:0.78rem;">
                    <span style="color:var(--muted);">Dibuat</span>
                    <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div style="border-top:1px solid var(--border);padding-top:0.625rem;display:flex;justify-content:space-between;align-items:baseline;">
                    <span style="font-size:0.62rem;letter-spacing:0.12em;text-transform:uppercase;">Total</span>
                    <span style="font-family:var(--font-display);font-size:1.25rem;font-weight:600;">
                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
