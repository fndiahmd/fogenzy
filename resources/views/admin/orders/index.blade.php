@extends('layouts.admin')
@section('title', 'Manajemen Order')
@section('topbar-title', 'Manajemen Order')

@section('content')
<div class="page-header">
    <h1>Orders</h1>
    <p>{{ $orders->total() }} total pesanan masuk</p>
</div>

<!-- STATUS FILTER -->
<div style="display:flex;gap:0;border-bottom:1px solid #e8e8e8;margin-bottom:1.5rem;overflow-x:auto;">
    @foreach(['all' => 'Semua', 'pending' => 'Pending', 'processing' => 'Diproses', 'shipped' => 'Dikirim', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'] as $val => $label)
    <a href="{{ route('admin.orders.index', $val !== 'all' ? ['status' => $val] : []) }}"
        style="padding:0.75rem 1.25rem;font-size:0.62rem;letter-spacing:0.12em;text-transform:uppercase;text-decoration:none;white-space:nowrap;border-bottom:2px solid transparent;margin-bottom:-1px;transition:all 0.2s;
        {{ (request('status') == $val || ($val == 'all' && !request('status'))) ? 'color:var(--noir);border-bottom-color:var(--noir);' : 'color:var(--muted);' }}">
        {{ $label }}
    </a>
    @endforeach
</div>

<div style="background:#fff;overflow-x:auto;">
    <table class="admin-table">
        <thead>
            <tr>
                <th>No. Order</th>
                <th>Pelanggan</th>
                <th>Item</th>
                <th>Total</th>
                <th>Pembayaran</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td style="font-family:var(--font-body);font-weight:500;font-size:0.8rem;letter-spacing:0.02em;">
                    {{ $order->order_number }}
                </td>
                <td>
                    <p style="font-size:0.8rem;margin:0;">{{ $order->user->name ?? '—' }}</p>
                    <p style="font-size:0.68rem;color:var(--muted);margin:0;">{{ $order->user->email ?? '' }}</p>
                </td>
                <td style="font-size:0.78rem;color:var(--muted);">{{ $order->items->count() }} item</td>
                <td style="font-family:var(--font-display);font-weight:600;font-size:0.9rem;">
                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                </td>
                <td style="font-size:0.75rem;">{{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</td>
                <td>
                    <span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                </td>
                <td style="font-size:0.72rem;color:var(--muted);">
                    {{ $order->created_at->format('d M Y') }}<br>
                    <span style="font-size:0.66rem;">{{ $order->created_at->format('H:i') }}</span>
                </td>
                <td style="white-space:nowrap;">
                    <a href="{{ route('admin.orders.show', $order) }}" class="action-link">Detail</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center;padding:3rem;color:var(--muted);font-size:0.82rem;">
                    Belum ada order masuk
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top:1.5rem;display:flex;justify-content:center;">
    {{ $orders->withQueryString()->links('vendor.pagination.bootstrap-5') }}
</div>
@endsection
