@extends('layouts.admin')
@section('title', 'Produk')
@section('topbar-title', 'Manajemen Produk')

@section('topbar-actions')
    <a href="{{ route('admin.products.create') }}" class="topbar-btn accent">+ Tambah Produk</a>
@endsection

@section('content')
<div class="page-header">
    <h1>Produk</h1>
    <p>{{ $products->total() }} total produk terdaftar</p>
</div>

<!-- SEARCH & FILTER -->
<form method="GET" action="{{ route('admin.products.index') }}" style="display:flex;gap:0.75rem;margin-bottom:1.5rem;flex-wrap:wrap;">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama produk..."
        style="border:1px solid #e0e0e0;border-radius:0;padding:0.5rem 0.875rem;font-family:var(--font-body);font-size:0.82rem;width:250px;outline:none;">
    <select name="category" style="border:1px solid #e0e0e0;border-radius:0;padding:0.5rem 0.875rem;font-family:var(--font-body);font-size:0.82rem;outline:none;background:#fff;">
        <option value="">Semua Kategori</option>
        @foreach(\App\Models\Category::all() as $cat)
            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
        @endforeach
    </select>
    <select name="stock" style="border:1px solid #e0e0e0;border-radius:0;padding:0.5rem 0.875rem;font-family:var(--font-body);font-size:0.82rem;outline:none;background:#fff;">
        <option value="">Semua Stok</option>
        <option value="low" {{ request('stock') == 'low' ? 'selected' : '' }}>Stok Rendah (&lt;5)</option>
        <option value="out" {{ request('stock') == 'out' ? 'selected' : '' }}>Habis</option>
    </select>
    <button type="submit" class="topbar-btn">Filter</button>
    @if(request()->anyFilled(['search','category','stock']))
        <a href="{{ route('admin.products.index') }}" class="topbar-btn">Reset</a>
    @endif
</form>

<!-- TABLE -->
<div style="background:#fff;overflow-x:auto;">
    <table class="admin-table">
        <thead>
            <tr>
                <th style="width:60px;">Foto</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td>
                    <div style="width:48px;height:64px;background:#f5f5f5;overflow:hidden;">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" style="width:100%;height:100%;object-fit:cover;" alt="">
                        @else
                            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;">
                                <span style="font-family:var(--font-display);font-size:1.1rem;color:#ccc;">{{ strtoupper(substr($product->name,0,1)) }}</span>
                            </div>
                        @endif
                    </div>
                </td>
                <td>
                    <p style="font-size:0.82rem;font-weight:400;margin:0;">{{ $product->name }}</p>
                    <p style="font-size:0.68rem;color:var(--muted);margin:0;font-family:monospace;">{{ $product->slug }}</p>
                </td>
                <td style="font-size:0.78rem;">{{ $product->category->name ?? '—' }}</td>
                <td style="font-size:0.82rem;font-family:var(--font-display);font-weight:600;">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td>
                    @if($product->stock == 0)
                        <span style="font-size:0.68rem;letter-spacing:0.08em;padding:0.25em 0.6em;background:#f8d7da;color:#721c24;">Habis</span>
                    @elseif($product->stock < 5)
                        <span style="font-size:0.68rem;letter-spacing:0.08em;padding:0.25em 0.6em;background:#fff3cd;color:#856404;">{{ $product->stock }} (Rendah)</span>
                    @else
                        <span style="font-size:0.78rem;color:var(--noir);">{{ $product->stock }}</span>
                    @endif
                </td>
                <td>
                    @if($product->is_active)
                        <span style="font-size:0.6rem;letter-spacing:0.1em;text-transform:uppercase;padding:0.25em 0.6em;background:#d4edda;color:#155724;">Aktif</span>
                    @else
                        <span style="font-size:0.6rem;letter-spacing:0.1em;text-transform:uppercase;padding:0.25em 0.6em;background:#f8d7da;color:#721c24;">Nonaktif</span>
                    @endif
                </td>
                <td style="white-space:nowrap;">
                    <a href="{{ route('products.show', $product->slug) }}" target="_blank" class="action-link" title="Lihat di store">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="{{ route('admin.products.edit', $product) }}" class="action-link">Edit</a>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus produk ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" style="background:none;border:none;cursor:pointer;" class="action-link danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;padding:3rem;color:var(--muted);font-size:0.82rem;">
                    Belum ada produk. <a href="{{ route('admin.products.create') }}" style="color:var(--noir);">Tambah sekarang</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- PAGINATION -->
<div style="margin-top:1.5rem;display:flex;justify-content:center;">
    {{ $products->withQueryString()->links('vendor.pagination.bootstrap-5') }}
</div>
@endsection
