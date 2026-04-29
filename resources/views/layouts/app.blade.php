<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FOGENZY — Fashion Store')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --noir: #0a0a0a;
            --blanc: #fafafa;
            --accent: #c9a96e;
            --muted: #6b6b6b;
            --border: #e8e8e8;
            --font-display: 'Cormorant Garamond', Georgia, serif;
            --font-body: 'Jost', sans-serif;
        }
        * { box-sizing: border-box; }
        body {
            font-family: var(--font-body);
            font-weight: 300;
            color: var(--noir);
            background: var(--blanc);
            letter-spacing: 0.01em;
        }
        h1, h2, h3, .display-font { font-family: var(--font-display); font-weight: 400; }

        /* ── NAVBAR ── */
        .noirvé-navbar {
            background: var(--blanc);
            border-bottom: 1px solid var(--border);
            padding: 0;
        }
        .noirvé-navbar .navbar-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 64px;
            padding: 0 2.5rem;
        }
        .brand-logo {
            font-family: var(--font-display);
            font-size: 1.6rem;
            font-weight: 600;
            letter-spacing: 0.15em;
            color: var(--noir);
            text-decoration: none;
        }
        .brand-logo span { color: var(--accent); }
        .nav-links { display: flex; gap: 2rem; align-items: center; }
        .nav-links a {
            font-size: 0.7rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--noir);
            text-decoration: none;
            font-weight: 400;
            transition: color 0.2s;
        }
        .nav-links a:hover, .nav-links a.active { color: var(--accent); }
        .nav-actions { display: flex; gap: 1.25rem; align-items: center; }
        .nav-icon-btn {
            background: none; border: none; padding: 4px; cursor: pointer;
            color: var(--noir); font-size: 1.1rem; position: relative;
            transition: color 0.2s;
        }
        .nav-icon-btn:hover { color: var(--accent); }
        .cart-badge {
            position: absolute; top: -4px; right: -6px;
            background: var(--noir); color: var(--blanc);
            width: 16px; height: 16px; border-radius: 50%;
            font-size: 9px; display: flex; align-items: center; justify-content: center;
            font-family: var(--font-body); font-weight: 500;
        }

        /* ── BUTTONS ── */
        .btn-noir {
            background: var(--noir); color: var(--blanc);
            border: 1.5px solid var(--noir); border-radius: 0;
            padding: 0.75rem 2rem; font-size: 0.7rem;
            letter-spacing: 0.18em; text-transform: uppercase;
            font-family: var(--font-body); font-weight: 400;
            transition: all 0.25s; cursor: pointer; text-decoration: none;
            display: inline-block;
        }
        .btn-noir:hover { background: transparent; color: var(--noir); }
        .btn-outline-noir {
            background: transparent; color: var(--noir);
            border: 1.5px solid var(--noir); border-radius: 0;
            padding: 0.75rem 2rem; font-size: 0.7rem;
            letter-spacing: 0.18em; text-transform: uppercase;
            font-family: var(--font-body); font-weight: 400;
            transition: all 0.25s; cursor: pointer; text-decoration: none;
            display: inline-block;
        }
        .btn-outline-noir:hover { background: var(--noir); color: var(--blanc); }
        .btn-accent {
            background: var(--accent); color: var(--blanc);
            border: 1.5px solid var(--accent); border-radius: 0;
            padding: 0.75rem 2rem; font-size: 0.7rem;
            letter-spacing: 0.18em; text-transform: uppercase;
            font-family: var(--font-body); font-weight: 400;
            transition: all 0.25s; cursor: pointer; text-decoration: none;
            display: inline-block;
        }
        .btn-accent:hover { background: transparent; color: var(--accent); }

        /* ── PRODUCT CARDS ── */
        .product-card {
            border: none; border-radius: 0; overflow: hidden;
            transition: transform 0.3s ease;
        }
        .product-card:hover { transform: translateY(-4px); }
        .product-img-wrap {
            position: relative; overflow: hidden;
            background: #f5f5f5; aspect-ratio: 3/4;
        }
        .product-img-wrap img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform 0.5s ease;
        }
        .product-card:hover .product-img-wrap img { transform: scale(1.04); }
        .product-overlay {
            position: absolute; bottom: 0; left: 0; right: 0;
            background: rgba(10,10,10,0.85); padding: 1rem;
            transform: translateY(100%); transition: transform 0.3s ease;
        }
        .product-card:hover .product-overlay { transform: translateY(0); }
        .product-card-body { padding: 0.875rem 0; }
        .product-card-name {
            font-size: 0.8rem; letter-spacing: 0.08em; text-transform: uppercase;
            color: var(--noir); margin-bottom: 0.25rem; font-weight: 400;
        }
        .product-card-cat {
            font-size: 0.7rem; color: var(--muted); letter-spacing: 0.05em;
            text-transform: uppercase; margin-bottom: 0.375rem;
        }
        .product-card-price {
            font-family: var(--font-display); font-size: 1rem; font-weight: 600;
            color: var(--noir);
        }

        /* ── FORMS ── */
        .form-control-noir {
            border: 1px solid var(--border); border-radius: 0;
            font-family: var(--font-body); font-weight: 300;
            font-size: 0.85rem; padding: 0.75rem 1rem;
            background: var(--blanc); color: var(--noir);
            transition: border-color 0.2s;
        }
        .form-control-noir:focus {
            border-color: var(--noir); box-shadow: none; outline: none;
            background: var(--blanc); color: var(--noir);
        }
        .form-label-noir {
            font-size: 0.65rem; letter-spacing: 0.15em; text-transform: uppercase;
            color: var(--muted); font-weight: 400; margin-bottom: 0.4rem;
        }

        /* ── HERO ── */
        .hero-section {
            background: var(--noir); color: var(--blanc);
            padding: 8rem 2.5rem;
            position: relative; overflow: hidden;
        }
        .hero-section::before {
            content: 'FOGENZY';
            position: absolute; right: -2rem; top: 50%;
            transform: translateY(-50%);
            font-family: var(--font-display);
            font-size: 16vw; color: rgba(255,255,255,0.03);
            line-height: 1; pointer-events: none;
        }
        .hero-tag {
            font-size: 0.65rem; letter-spacing: 0.25em; text-transform: uppercase;
            color: var(--accent); margin-bottom: 1.5rem;
        }
        .hero-title {
            font-family: var(--font-display); font-weight: 300;
            font-size: clamp(3rem, 6vw, 5.5rem);
            line-height: 1.05; margin-bottom: 1.5rem;
        }
        .hero-sub {
            font-size: 0.85rem; color: rgba(250,250,250,0.6);
            max-width: 38ch; margin-bottom: 2.5rem; line-height: 1.7;
        }

        /* ── SECTION HEADERS ── */
        .section-eyebrow {
            font-size: 0.65rem; letter-spacing: 0.25em; text-transform: uppercase;
            color: var(--accent); margin-bottom: 0.75rem;
        }
        .section-title {
            font-family: var(--font-display); font-weight: 300;
            font-size: clamp(2rem, 4vw, 3rem); line-height: 1.1;
            margin-bottom: 0;
        }

        /* ── ALERTS ── */
        .alert-noirvé {
            border-radius: 0; border-left: 3px solid var(--accent);
            background: rgba(201,169,110,0.08); color: var(--noir);
            font-size: 0.82rem; padding: 0.75rem 1rem;
        }
        .alert-success-noir {
            border-left-color: #2d6a4f;
            background: rgba(45,106,79,0.06);
        }
        .alert-danger-noir {
            border-left-color: #c0392b;
            background: rgba(192,57,43,0.06);
        }

        /* ── STATUS BADGES ── */
        .status-badge {
            font-size: 0.6rem; letter-spacing: 0.12em; text-transform: uppercase;
            padding: 0.3em 0.8em; border-radius: 0; font-weight: 500;
        }
        .status-pending    { background: #fff3cd; color: #856404; }
        .status-processing { background: #cff4fc; color: #0c5460; }
        .status-shipped    { background: #d1ecf1; color: #0c5460; }
        .status-completed  { background: #d4edda; color: #155724; }
        .status-cancelled  { background: #f8d7da; color: #721c24; }

        /* ── FOOTER ── */
        .site-footer {
            background: var(--noir); color: rgba(250,250,250,0.5);
            padding: 5rem 2.5rem 2rem; margin-top: 6rem;
        }
        .footer-brand {
            font-family: var(--font-display); font-size: 1.75rem;
            color: var(--blanc); letter-spacing: 0.15em; margin-bottom: 0.75rem;
        }
        .footer-tagline { font-size: 0.75rem; letter-spacing: 0.1em; }
        .footer-links a {
            display: block; color: rgba(250,250,250,0.5);
            text-decoration: none; font-size: 0.72rem; letter-spacing: 0.08em;
            text-transform: uppercase; margin-bottom: 0.6rem; transition: color 0.2s;
        }
        .footer-links a:hover { color: var(--accent); }
        .footer-bottom {
            border-top: 1px solid rgba(250,250,250,0.08);
            padding-top: 2rem; margin-top: 3rem;
            font-size: 0.65rem; letter-spacing: 0.08em; text-transform: uppercase;
        }
        @media (max-width: 768px) {
            .noirvé-navbar .navbar-inner { padding: 0 1.25rem; }
            .nav-links { display: none; }
            .hero-section { padding: 5rem 1.25rem; }
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- NAVBAR -->
<nav class="noirvé-navbar sticky-top">
    <div class="navbar-inner">
        <a href="{{ route('home') }}" class="brand-logo">FO<span>GENZY</span></a>

        <div class="nav-links">
            <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">Collection</a>
            <a href="{{ route('products.index', ['category' => 'wanita']) }}">Wanita</a>
            <a href="{{ route('products.index', ['category' => 'pria']) }}">Pria</a>
            <a href="{{ route('products.index', ['category' => 'aksesoris']) }}">Aksesoris</a>
        </div>

        <div class="nav-actions">
            @auth
                <a href="{{ route('orders.index') }}" class="nav-icon-btn" title="Orders">
                    <i class="bi bi-bag"></i>
                </a>
                <a href="{{ route('cart.index') }}" class="nav-icon-btn" title="Cart">
                    <i class="bi bi-bag-heart"></i>
                    @php $cartCount = auth()->user()->carts()->count(); @endphp
                    @if($cartCount > 0)
                        <span class="cart-badge">{{ $cartCount }}</span>
                    @endif
                </a>
                <div class="dropdown">
                    <button class="nav-icon-btn" data-bs-toggle="dropdown">
                        <i class="bi bi-person"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end rounded-0 border-0 shadow-sm py-0">
                        <li><a class="dropdown-item py-2 small" href="{{ route('profile.edit') }}">Profile</a></li>
                        @if(auth()->user()->is_admin)
                            <li><a class="dropdown-item py-2 small" href="{{ route('admin.dashboard') }}">Admin Panel</a></li>
                        @endif
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 small">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn-outline-noir" style="padding: 0.5rem 1.25rem; font-size: 0.65rem;">Login</a>
                <a href="{{ route('register') }}" class="btn-noir" style="padding: 0.5rem 1.25rem; font-size: 0.65rem;">Register</a>
            @endauth
        </div>
    </div>
</nav>

<!-- FLASH MESSAGES -->
@if(session('success'))
    <div class="alert-noirvé alert-success-noir px-4 py-3" role="alert">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert-noirvé alert-danger-noir px-4 py-3" role="alert">
        {{ session('error') }}
    </div>
@endif

<!-- MAIN CONTENT -->
<main>
    @yield('content')
</main>

<!-- FOOTER -->
<footer class="site-footer">
    <div class="container-fluid">
        <div class="row g-5">
            <div class="col-lg-4">
                <div class="footer-brand">FOGENZY</div>
                <p class="footer-tagline">Refined Fashion. Minimal Aesthetics.</p>
                <div class="d-flex gap-3 mt-3">
                    <a href="#" style="color:rgba(250,250,250,0.4); font-size:1.1rem;"><i class="bi bi-instagram"></i></a>
                    <a href="#" style="color:rgba(250,250,250,0.4); font-size:1.1rem;"><i class="bi bi-tiktok"></i></a>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <p style="font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;color:rgba(250,250,250,0.3);margin-bottom:1rem;">Koleksi</p>
                <div class="footer-links">
                    <a href="#">New Arrival</a>
                    <a href="#">Wanita</a>
                    <a href="#">Pria</a>
                    <a href="#">Aksesoris</a>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <p style="font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;color:rgba(250,250,250,0.3);margin-bottom:1rem;">Layanan</p>
                <div class="footer-links">
                    <a href="#">Panduan Ukuran</a>
                    <a href="#">Pengiriman</a>
                    <a href="#">Pengembalian</a>
                    <a href="#">Kontak</a>
                </div>
            </div>
        </div>
        <div class="footer-bottom d-flex justify-content-between">
            <span>© {{ date('Y') }} FOGENZY. All rights reserved.</span>
            <span>Jakarta, Indonesia</span>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
