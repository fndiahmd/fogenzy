@extends('layouts.admin')
@section('title', 'Edit Kategori')
@section('topbar-title', 'Edit Kategori')

@section('topbar-actions')
    <a href="{{ route('admin.categories.index') }}" class="topbar-btn">← Kembali</a>
@endsection

@section('content')
<div class="page-header">
    <h1>Edit Kategori</h1>
    <p>{{ $category->name }}</p>
</div>

<div style="max-width:600px;">
    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf @method('PUT')
        @include('admin.categories._form')
    </form>
</div>
@endsection
