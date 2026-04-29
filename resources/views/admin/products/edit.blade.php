@extends('layouts.admin')
@section('title', 'Edit Produk')
@section('topbar-title', 'Edit Produk')

@section('topbar-actions')
    <a href="{{ route('admin.products.index') }}" class="topbar-btn">← Kembali</a>
@endsection

@section('content')
<div class="page-header">
    <h1>Edit Produk</h1>
    <p>{{ $product->name }}</p>
</div>

<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    @include('admin.products._form')
</form>
@endsection
