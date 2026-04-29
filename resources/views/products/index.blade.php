@extends('layouts.app')
@section('title', 'Koleksi — FOGENZY')

@section('content')
<div style="background:var(--noir);padding:4rem 2.5rem 3.5rem;color:#fafafa;position:relative;overflow:hidden;">
    <div style="position:absolute;right:-1rem;top:50%;transform:translateY(-50%);font-family:var(--font-display);font-size:14vw;color:rgba(255,255,255,0.025);line-height:1;pointer-events:none;">COLLECTION</div>
    <p style="font-size:0.6rem;letter-spacing:0.3em;text-transform:uppercase;color:#c9a96e;margin-bottom:0.75rem;">FOGENZY — 2025</p>
    <h1 style="font-family:var(--font-display);font-weight:300;font-size:clamp(2.5rem,5vw,4.5rem);line-height:1.05;margin:0;">The New Collection</h1>
</div>

<div class="container-fluid px-4 px-md-5 py-5">
    <div class="row g-0">
        <div class="col-lg-2 pe-lg-5 mb-4 mb-lg-0">
            <div style="position:sticky;top:80px;">
                <form method="GET" action="{{ route('products.index') }}">
                    <p style="font-size:0.6rem;letter-spacing:0.22em;text-transform:uppercase;color:var(--muted);margin-bottom:1.25rem;">Filter</p>

                    <div class="mb-4">
                        <p style="font-size:0.6rem;letter-spacing:0.15em;text-transform:uppercase;color:#999;margin-bottom:0.75rem;">Kategori</p>
                        <div class="d-flex flex-column gap-2">
                            <label style="font-size:0.75rem;cursor:pointer;display:flex;align-items:center;gap:0.5rem;">
                                <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }} style="accent-color:var(--noir);">
                                Semua
                            </label>
                            @foreach($categories as $cat)
                            <label style="font-size:0.75rem;cursor:pointer;display:flex;align-items:center;gap:0.5rem;">
                                <input type="radio" name="category" value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'checked' : '' }} style="accent-color:var(--noir);">
                                {{ $cat->name }}
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-4">
                        <p style="font-size:0.6rem;letter-spacing:0.15em;text-transform:uppercase;color:#999;margin-bottom:0.75rem;">Urutkan</p>
                        <select name="sort" style="border:1px solid #e0e0e0;border-radius:0;font-family:var(--font-body);font-size:0.75rem;padding:0.5rem;width:100%;background:#fff;">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-noir w-100" style="padding:0.65rem;">Terapkan</button>
                    @if(request()->anyFilled(['category', 'sort', 'search']))
                        <a href="{{ route('products.index') }}" style="display:block;text-align:center;margin-top:0.75rem;font-size:0.65rem;letter-spacing:0.12em;text-transform:uppercase;color:var(--muted);text-decoration:none;">Reset</a>
                    @endif
                </form>
            </div>
        </div>

        <div class="col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <span style="font-size:0.7rem;color:var(--muted);">{{ $products->total() }} produk</span>
                    @if(request('category'))
                        <span style="font-size:0.7rem;color:var(--accent);margin-left:0.5rem;">— {{ request('category') }}</span>
                    @endif
                </div>
                <form method="GET" action="{{ route('products.index') }}" class="d-flex">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari produk..."
                        style="border:1px solid #e0e0e0;border-right:none;padding:0.5rem 0.875rem;font-family:var(--font-body);font-size:0.78rem;width:200px;outline:none;border-radius:0;">
                    <button type="submit" style="border:1px solid #e0e0e0;background:var(--noir);color:#fff;padding:0.5rem 0.875rem;cursor:pointer;border-radius:0;">
                        <i class="bi bi-search" style="font-size:0.8rem;"></i>
                    </button>
                </form>
            </div>

            @if($products->isEmpty())
                <div style="text-align:center;padding:6rem 0;">
                    <p style="font-family:var(--font-display);font-size:2rem;font-weight:300;color:#ccc;">Tidak ada produk</p>
                    <p style="font-size:0.78rem;color:var(--muted);">Coba filter atau pencarian yang berbeda</p>
                </div>
            @else
                <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 g-3 g-md-4">
                    @foreach($products as $product)
                    <div class="col">
                        <div class="product-card">
                            <div class="product-img-wrap">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" loading="lazy">
                                @else
                                    <div style="width:100%;height:100%;background:#f0ede8;display:flex;align-items:center;justify-content:center;">
                                        <span style="font-family:var(--font-display);font-size:1.25rem;color:#ccc;">{{ strtoupper(substr($product->name,0,1)) }}</span>
                                    </div>
                                @endif

                                <div class="product-overlay">
                                    @auth
                                        <form action="{{ route('cart.add', $product) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" style="width:100%;background:none;border:1px solid rgba(255,255,255,0.5);color:#fff;font-family:var(--font-body);font-size:0.65rem;letter-spacing:0.15em;text-transform:uppercase;padding:0.6rem;cursor:pointer;transition:all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.1)'" onmouseout="this.style.background='none'">
                                                + Keranjang
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" style="display:block;text-align:center;border:1px solid rgba(255,255,255,0.5);color:#fff;font-size:0.65rem;letter-spacing:0.15em;text-transform:uppercase;padding:0.6rem;text-decoration:none;">
                                            Login to Add
                                        </a>
                                    @endauth
                                </div>

                                @if($product->stock < 5 && $product->stock > 0)
                                    <div style="position:absolute;top:10px;left:10px;background:var(--accent);color:#fff;font-size:0.55rem;letter-spacing:0.1em;text-transform:uppercase;padding:0.2rem 0.6rem;">
                                        Sisa {{ $product->stock }}
                                    </div>
                                @endif
                                @if($product->stock == 0)
                                    <div style="position:absolute;inset:0;background:rgba(250,250,250,0.7);display:flex;align-items:center;justify-content:center;">
                                        <span style="font-size:0.65rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--muted);">Habis</span>
                                    </div>
                                @endif
                            </div>

                            <div class="product-card-body">
                                <a href="{{ route('products.show', $product->slug) }}" style="text-decoration:none;">
                                    <p class="product-card-cat">{{ $product->category->name ?? '' }}</p>
                                    <p class="product-card-name">{{ $product->name }}</p>
                                    <p class="product-card-price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-5 d-flex justify-content-center">
                    {{ $products->withQueryString()->links('vendor.pagination.bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
