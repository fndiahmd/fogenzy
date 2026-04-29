{{-- ============================================================
     FILE: resources/views/admin/products/create.blade.php
     ============================================================ --}}
@extends('layouts.admin')
@section('title', 'Tambah Produk')
@section('topbar-title', 'Tambah Produk Baru')

@section('topbar-actions')
    <a href="{{ route('admin.products.index') }}" class="topbar-btn">← Kembali</a>
@endsection

@section('content')
<div class="page-header">
    <h1>Tambah Produk</h1>
    <p>Isi detail produk baru untuk FOGENZY store</p>
</div>

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('admin.products._form')
</form>
@endsection
