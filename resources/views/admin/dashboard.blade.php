@extends('layouts.admin')
@section('title', 'Dashboard')
@section('topbar-title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1>Dashboard</h1>
    <p>Selamat datang kembali, {{ auth()->user()->name }}</p>
</div>

<!-- STAT CARDS -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-label">Total Orders</div>
            <div class="stat-value">{{ $stats['total_orders'] }}</div>
            <div class="stat-sub">{{ $stats['pending_orders'] }} pending</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card accent-card">
            <div class="stat-label">Revenue</div>
            <div class="stat-value" style="font-size:1.5rem;">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
            <div class="stat-sub">Semua order selesai</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-label">Produk Aktif</div>
            <div class="stat-value">{{ $stats['total_products'] }}</div>
            <div class="stat-sub">{{ $stats['low_stock'] }} stok rendah</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-label">Total User</div>
            <div class="stat-value">{{ $stats['total_users'] }}</div>
            <div class="stat-sub">Pelanggan terdaftar</div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- RECENT ORDERS -->
    <div class="col-lg-8">
        <div style="background:#fff;border-top:2px solid var(--noir);">
            <div style="padding:1.25rem 1.5rem;border-bottom:1px solid #f0f0f0;display:flex;justify-content:space-between;align-items:center;">
                <span style="font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;">Order Terbaru</span>
                <a href="{{ route('admin.orders.index') }}" style="font-size:0.65rem;letter-spacing:0.1em;text-transform:uppercase;color:var(--muted);text-decoration:none;">Lihat Semua</a>
            </div>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>No. Order</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent_orders as $order)
                    <tr>
                        <td style="font-family:var(--font-body);font-weight:500;font-size:0.78rem;">{{ $order->order_number }}</td>
                        <td style="font-size:0.8rem;">{{ $order->user->name ?? '-' }}</td>
                        <td style="font-size:0.8rem;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td>
                            <span class="status-badge status-{{ $order->status }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td style="font-size:0.72rem;color:var(--muted);">{{ $order->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="action-link">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align:center;padding:3rem;color:var(--muted);font-size:0.8rem;">Belum ada order</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- QUICK ACTIONS -->
    <div class="col-lg-4">
        <div style="background:#fff;border-top:2px solid var(--accent);padding:1.25rem 1.5rem;margin-bottom:1rem;">
            <p style="font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:1.25rem;">Aksi Cepat</p>
            <div class="d-grid gap-2">
                <a href="{{ route('admin.products.create') }}" class="topbar-btn text-center" style="display:block;">+ Tambah Produk</a>
                <a href="{{ route('admin.categories.create') }}" class="topbar-btn text-center" style="display:block;">+ Tambah Kategori</a>
                <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="topbar-btn text-center" style="display:block;">Lihat Order Pending ({{ $stats['pending_orders'] }})</a>
            </div>
        </div>

        @if($stats['low_stock'] > 0)
        <div style="background:#fff;border-top:2px solid #c0392b;padding:1.25rem 1.5rem;">
            <p style="font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;color:#c0392b;margin-bottom:0.75rem;">Stok Rendah</p>
            <p style="font-size:0.78rem;color:var(--muted);">{{ $stats['low_stock'] }} produk memiliki stok di bawah 5 unit. Segera perbarui stok.</p>
            <a href="{{ route('admin.products.index') }}" class="topbar-btn" style="display:inline-block;margin-top:0.75rem;font-size:0.62rem;">Kelola Produk</a>
        </div>
        @endif
    </div>
</div>
@endsection
