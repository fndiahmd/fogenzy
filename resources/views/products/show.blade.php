@extends('layouts.app')
@section('title', $product->name . ' — FOGENZY')

@section('content')
<div class="container-fluid px-4 px-md-5 py-5">
    <!-- BREADCRUMB -->
    <nav style="margin-bottom:2rem;">
        <span style="font-size:0.65rem;letter-spacing:0.1em;text-transform:uppercase;color:var(--muted);">
            <a href="{{ route('home') }}" style="color:var(--muted);text-decoration:none;">Home</a>
            <span style="margin:0 0.5rem;">·</span>
            <a href="{{ route('products.index') }}" style="color:var(--muted);text-decoration:none;">Koleksi</a>
            <span style="margin:0 0.5rem;">·</span>
            <span style="color:var(--noir);">{{ $product->name }}</span>
        </span>
    </nav>

    <div class="row g-5">
        <!-- LEFT: IMAGE -->
        <div class="col-lg-7">
            <div style="background:#f5f5f5;aspect-ratio:4/5;overflow:hidden;position:relative;">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                        style="width:100%;height:100%;object-fit:cover;">
                @else
                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:#f0ede8;">
                        <span style="font-family:var(--font-display);font-size:6rem;color:#ddd;font-weight:300;">
                            {{ strtoupper(substr($product->name,0,1)) }}
                        </span>
                    </div>
                @endif

                @if($product->stock == 0)
                    <div style="position:absolute;inset:0;background:rgba(250,250,250,0.75);display:flex;align-items:center;justify-content:center;">
                        <span style="font-size:0.7rem;letter-spacing:0.25em;text-transform:uppercase;color:var(--muted);">Stok Habis</span>
                    </div>
                @elseif($product->stock < 5)
                    <div style="position:absolute;top:1rem;left:1rem;background:var(--accent);color:#fff;font-size:0.6rem;letter-spacing:0.12em;text-transform:uppercase;padding:0.3rem 0.75rem;">
                        Sisa {{ $product->stock }} item
                    </div>
                @endif
            </div>
        </div>

        <!-- RIGHT: INFO -->
        <div class="col-lg-5">
            <div style="position:sticky;top:90px;">
                <p style="font-size:0.62rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--accent);margin-bottom:0.5rem;">
                    {{ $product->category->name ?? '' }}
                </p>
                <h1 style="font-family:var(--font-display);font-weight:300;font-size:2.25rem;line-height:1.1;margin-bottom:1rem;">
                    {{ $product->name }}
                </h1>
                <p style="font-family:var(--font-display);font-size:1.75rem;font-weight:600;margin-bottom:2rem;">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>

                <!-- DESCRIPTION -->
                <div style="margin-bottom:2.5rem;">
                    <p style="font-size:0.82rem;line-height:1.8;color:#444;">{{ $product->description }}</p>
                </div>

                <!-- STOCK INFO -->
                <div style="margin-bottom:1.5rem;">
                    @if($product->stock > 0)
                        <p style="font-size:0.68rem;letter-spacing:0.1em;text-transform:uppercase;color:#2d6a4f;">
                            ✓ Tersedia ({{ $product->stock }} unit)
                        </p>
                    @else
                        <p style="font-size:0.68rem;letter-spacing:0.1em;text-transform:uppercase;color:#c0392b;">
                            Stok habis
                        </p>
                    @endif
                </div>

                <!-- ADD TO CART FORM -->
                @if($product->stock > 0)
                    @auth
                        <form action="{{ route('cart.add', $product) }}" method="POST">
                            @csrf
                            <div style="display:flex;gap:0.75rem;margin-bottom:1rem;">
                                <div style="display:flex;align-items:center;border:1px solid var(--border);">
                                    <button type="button" onclick="changeQty(-1)" style="width:44px;height:48px;background:none;border:none;cursor:pointer;font-size:1.2rem;">−</button>
                                    <input type="number" name="quantity" id="qty" value="1" min="1" max="{{ $product->stock }}"
                                        style="width:52px;text-align:center;border:none;border-left:1px solid var(--border);border-right:1px solid var(--border);height:48px;font-family:var(--font-body);font-size:0.9rem;outline:none;">
                                    <button type="button" onclick="changeQty(1)" style="width:44px;height:48px;background:none;border:none;cursor:pointer;font-size:1.2rem;">+</button>
                                </div>
                                <button type="submit" class="btn-noir" style="flex:1;font-size:0.72rem;letter-spacing:0.15em;">
                                    Tambah ke Keranjang
                                </button>
                            </div>
                        </form>
                        <a href="{{ route('cart.index') }}" class="btn-outline-noir" style="display:block;text-align:center;font-size:0.72rem;letter-spacing:0.15em;">
                            Lihat Keranjang
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-noir" style="display:block;text-align:center;font-size:0.72rem;letter-spacing:0.15em;">
                            Login untuk Membeli
                        </a>
                    @endauth
                @endif

                <!-- DETAILS ACCORDION -->
                <div style="margin-top:2.5rem;border-top:1px solid var(--border);">
                    <details style="border-bottom:1px solid var(--border);">
                        <summary style="padding:1rem 0;font-size:0.68rem;letter-spacing:0.15em;text-transform:uppercase;cursor:pointer;list-style:none;display:flex;justify-content:space-between;">
                            Pengiriman & Pengembalian
                            <span>+</span>
                        </summary>
                        <div style="padding-bottom:1rem;font-size:0.78rem;color:var(--muted);line-height:1.8;">
                            <p>Pengiriman ke seluruh Indonesia dalam 2–5 hari kerja.</p>
                            <p>Pengembalian barang dapat dilakukan dalam 14 hari setelah penerimaan.</p>
                        </div>
                    </details>
                    <details style="border-bottom:1px solid var(--border);">
                        <summary style="padding:1rem 0;font-size:0.68rem;letter-spacing:0.15em;text-transform:uppercase;cursor:pointer;list-style:none;display:flex;justify-content:space-between;">
                            Perawatan Produk
                            <span>+</span>
                        </summary>
                        <div style="padding-bottom:1rem;font-size:0.78rem;color:var(--muted);line-height:1.8;">
                            <p>Cuci dengan tangan menggunakan air dingin. Jangan diperas. Keringkan di tempat teduh.</p>
                        </div>
                    </details>
                </div>
            </div>
        </div>
    </div>

    <!-- RELATED PRODUCTS -->
    @if($related->isNotEmpty())
    <div style="margin-top:6rem;">
        <div style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:2.5rem;">
            <div>
                <p style="font-size:0.6rem;letter-spacing:0.25em;text-transform:uppercase;color:var(--accent);margin-bottom:0.5rem;">Produk Serupa</p>
                <h2 style="font-family:var(--font-display);font-weight:300;font-size:2rem;margin:0;">Mungkin Juga Suka</h2>
            </div>
            <a href="{{ route('products.index', ['category' => $product->category->slug ?? '']) }}" style="font-size:0.65rem;letter-spacing:0.12em;text-transform:uppercase;color:var(--muted);text-decoration:none;">Lihat Semua</a>
        </div>
        <div class="row row-cols-2 row-cols-md-4 g-3 g-md-4">
            @foreach($related as $rel)
            <div class="col">
                <div class="product-card">
                    <div class="product-img-wrap">
                        @if($rel->image)
                            <img src="{{ asset('storage/' . $rel->image) }}" alt="{{ $rel->name }}" loading="lazy">
                        @else
                            <div style="width:100%;height:100%;background:#f0ede8;display:flex;align-items:center;justify-content:center;">
                                <span style="font-family:var(--font-display);font-size:2rem;color:#ccc;">{{ strtoupper(substr($rel->name,0,1)) }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="product-card-body">
                        <a href="{{ route('products.show', $rel->slug) }}" style="text-decoration:none;">
                            <p class="product-card-cat">{{ $rel->category->name ?? '' }}</p>
                            <p class="product-card-name">{{ $rel->name }}</p>
                            <p class="product-card-price">Rp {{ number_format($rel->price, 0, ',', '.') }}</p>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
function changeQty(delta) {
    const input = document.getElementById('qty');
    let val = parseInt(input.value) + delta;
    if (val < 1) val = 1;
    if (val > parseInt(input.max)) val = parseInt(input.max);
    input.value = val;
}
</script>
@endpush
@endsection
