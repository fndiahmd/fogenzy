{{-- ============================================================
     FILE: resources/views/admin/categories/index.blade.php
     ============================================================ --}}
@extends('layouts.admin')
@section('title', 'Kategori')
@section('topbar-title', 'Manajemen Kategori')

@section('topbar-actions')
    <a href="{{ route('admin.categories.create') }}" class="topbar-btn accent">+ Tambah Kategori</a>
@endsection

@section('content')
<div class="page-header">
    <h1>Kategori</h1>
    <p>{{ $categories->count() }} kategori terdaftar</p>
</div>

<div style="background:#fff;overflow-x:auto;">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Slug</th>
                <th>Deskripsi</th>
                <th>Jumlah Produk</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
            <tr>
                <td style="font-size:0.85rem;font-weight:500;">{{ $category->name }}</td>
                <td style="font-family:monospace;font-size:0.72rem;color:var(--muted);">{{ $category->slug }}</td>
                <td style="font-size:0.78rem;color:var(--muted);max-width:300px;">{{ Str::limit($category->description, 60) ?? '—' }}</td>
                <td style="font-size:0.82rem;">{{ $category->products_count ?? $category->products()->count() }} produk</td>
                <td style="white-space:nowrap;">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="action-link">Edit</a>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline;"
                        onsubmit="return confirm('Hapus kategori ini? Produk terkait perlu dipindahkan dulu.')">
                        @csrf @method('DELETE')
                        <button type="submit" class="action-link danger" style="background:none;border:none;cursor:pointer;">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center;padding:3rem;color:var(--muted);font-size:0.82rem;">
                    Belum ada kategori. <a href="{{ route('admin.categories.create') }}" style="color:var(--noir);">Tambah sekarang</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
