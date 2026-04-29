<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — FOGENZY</title>
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
            --sidebar-w: 240px;
            --font-display: 'Cormorant Garamond', Georgia, serif;
            --font-body: 'Jost', sans-serif;
        }
        body { font-family: var(--font-body); font-weight: 300; background: #f2f2f0; color: var(--noir); }

        /* SIDEBAR */
        .admin-sidebar {
            position: fixed; top: 0; left: 0; bottom: 0;
            width: var(--sidebar-w); background: var(--noir); z-index: 100;
            display: flex; flex-direction: column; padding: 2rem 0;
        }
        .sidebar-brand {
            font-family: var(--font-display); font-size: 1.4rem;
            letter-spacing: 0.15em; color: var(--blanc);
            padding: 0 1.5rem 2rem; border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .sidebar-brand span { color: var(--accent); }
        .sidebar-sub {
            font-size: 0.55rem; letter-spacing: 0.2em; text-transform: uppercase;
            color: rgba(255,255,255,0.3); margin-top: 2px;
        }
        .sidebar-nav { flex: 1; padding: 1.5rem 0; overflow-y: auto; }
        .sidebar-section {
            font-size: 0.55rem; letter-spacing: 0.2em; text-transform: uppercase;
            color: rgba(255,255,255,0.25); padding: 0 1.5rem;
            margin-top: 1.5rem; margin-bottom: 0.5rem;
        }
        .sidebar-link {
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.65rem 1.5rem;
            font-size: 0.75rem; letter-spacing: 0.06em;
            color: rgba(255,255,255,0.55); text-decoration: none;
            transition: all 0.2s; border-left: 2px solid transparent;
        }
        .sidebar-link:hover { color: var(--blanc); background: rgba(255,255,255,0.04); }
        .sidebar-link.active { color: var(--accent); border-left-color: var(--accent); background: rgba(201,169,110,0.08); }
        .sidebar-link i { font-size: 0.9rem; width: 16px; }
        .sidebar-footer {
            padding: 1rem 1.5rem; border-top: 1px solid rgba(255,255,255,0.08);
        }
        .sidebar-user { font-size: 0.7rem; color: rgba(255,255,255,0.4); }
        .sidebar-user strong { display: block; color: rgba(255,255,255,0.7); margin-bottom: 2px; }

        /* MAIN CONTENT */
        .admin-main {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
        }
        .admin-topbar {
            background: var(--blanc); border-bottom: 1px solid #e0e0e0;
            padding: 0 2rem; height: 56px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 50;
        }
        .topbar-title { font-size: 0.7rem; letter-spacing: 0.15em; text-transform: uppercase; color: var(--muted); }
        .topbar-actions { display: flex; align-items: center; gap: 1rem; }
        .topbar-btn {
            font-size: 0.65rem; letter-spacing: 0.12em; text-transform: uppercase;
            padding: 0.5rem 1.25rem; border: 1px solid #e0e0e0; background: var(--blanc);
            cursor: pointer; text-decoration: none; color: var(--noir);
            transition: all 0.2s;
        }
        .topbar-btn:hover { background: var(--noir); color: var(--blanc); border-color: var(--noir); }
        .topbar-btn.accent { background: var(--noir); color: var(--blanc); border-color: var(--noir); }
        .topbar-btn.accent:hover { background: var(--accent); border-color: var(--accent); }

        .admin-page { padding: 2.5rem 2rem; }
        .page-header { margin-bottom: 2rem; }
        .page-header h1 {
            font-family: var(--font-display); font-weight: 300;
            font-size: 2rem; margin: 0;
        }
        .page-header p { font-size: 0.78rem; color: var(--muted); margin-top: 0.25rem; }

        /* STAT CARDS */
        .stat-card {
            background: var(--blanc); border-top: 2px solid var(--noir);
            padding: 1.5rem; position: relative; overflow: hidden;
        }
        .stat-card .stat-label {
            font-size: 0.6rem; letter-spacing: 0.2em; text-transform: uppercase;
            color: var(--muted); margin-bottom: 0.75rem;
        }
        .stat-card .stat-value {
            font-family: var(--font-display); font-size: 2.25rem;
            font-weight: 600; line-height: 1; color: var(--noir);
        }
        .stat-card .stat-sub { font-size: 0.7rem; color: var(--muted); margin-top: 0.5rem; }
        .stat-card.accent-card { border-top-color: var(--accent); }
        .stat-card.accent-card .stat-value { color: var(--accent); }

        /* ADMIN TABLE */
        .admin-table { background: var(--blanc); width: 100%; border-collapse: collapse; }
        .admin-table thead th {
            font-size: 0.6rem; letter-spacing: 0.2em; text-transform: uppercase;
            color: var(--muted); padding: 1rem 1.25rem;
            border-bottom: 1px solid #e8e8e8; font-weight: 500;
            background: #f8f8f6;
        }
        .admin-table tbody td {
            padding: 1rem 1.25rem; font-size: 0.82rem;
            border-bottom: 1px solid #f0f0f0; vertical-align: middle;
        }
        .admin-table tbody tr:hover { background: #f8f8f6; }
        .admin-table tbody tr:last-child td { border-bottom: none; }

        /* ADMIN FORM */
        .admin-form-card { background: var(--blanc); padding: 2rem; }
        .form-section-title {
            font-size: 0.6rem; letter-spacing: 0.2em; text-transform: uppercase;
            color: var(--muted); padding-bottom: 0.75rem;
            border-bottom: 1px solid #e8e8e8; margin-bottom: 1.5rem;
        }
        .form-control, .form-select {
            border-radius: 0; border-color: #e0e0e0;
            font-family: var(--font-body); font-weight: 300;
            font-size: 0.85rem; padding: 0.65rem 0.875rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--noir); box-shadow: none;
        }
        .form-label {
            font-size: 0.65rem; letter-spacing: 0.12em; text-transform: uppercase;
            color: var(--muted); font-weight: 400;
        }

        /* STATUS BADGES */
        .status-badge {
            font-size: 0.6rem; letter-spacing: 0.1em; text-transform: uppercase;
            padding: 0.3em 0.7em; font-weight: 500;
        }
        .status-pending    { background: #fff3cd; color: #856404; }
        .status-processing { background: #cff4fc; color: #0c5460; }
        .status-shipped    { background: #d1ecf1; color: #0c5460; }
        .status-completed  { background: #d4edda; color: #155724; }
        .status-cancelled  { background: #f8d7da; color: #721c24; }

        /* ACTION LINKS */
        .action-link {
            font-size: 0.65rem; letter-spacing: 0.1em; text-transform: uppercase;
            color: var(--muted); text-decoration: none; margin-right: 0.75rem;
            transition: color 0.2s;
        }
        .action-link:hover { color: var(--noir); }
        .action-link.danger:hover { color: #c0392b; }

        /* FLASH */
        .admin-flash {
            font-size: 0.78rem; padding: 0.875rem 1.25rem;
            border-left: 3px solid var(--accent); background: rgba(201,169,110,0.08);
            margin-bottom: 1.5rem;
        }
        .admin-flash.success { border-left-color: #2d6a4f; background: rgba(45,106,79,0.06); }
        .admin-flash.danger  { border-left-color: #c0392b; background: rgba(192,57,43,0.06); }

        /* PAGINATION */
        .pagination .page-link { border-radius: 0; font-size: 0.78rem; color: var(--noir); }
        .pagination .page-item.active .page-link { background: var(--noir); border-color: var(--noir); }
    </style>
    @stack('styles')
</head>
<body>

<!-- SIDEBAR -->
<aside class="admin-sidebar">
    <div class="sidebar-brand">
        FO<span>GENZY</span>
        <div class="sidebar-sub">Admin Panel</div>
    </div>
    <nav class="sidebar-nav">
        <div class="sidebar-section">Overview</div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2"></i> Dashboard
        </a>

        <div class="sidebar-section">Katalog</div>
        <a href="{{ route('admin.products.index') }}" class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="bi bi-handbag"></i> Produk
        </a>
        <a href="{{ route('admin.categories.index') }}" class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="bi bi-tags"></i> Kategori
        </a>

        <div class="sidebar-section">Penjualan</div>
        <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="bi bi-bag-check"></i> Orders
        </a>

        <div class="sidebar-section">Akun</div>
        <a href="{{ route('home') }}" class="sidebar-link" target="_blank">
            <i class="bi bi-box-arrow-up-right"></i> Lihat Store
        </a>
    </nav>
    <div class="sidebar-footer">
        <div class="sidebar-user">
            <strong>{{ auth()->user()->name ?? 'Admin' }}</strong>
            {{ auth()->user()->email ?? '' }}
        </div>
        <form action="{{ route('logout') }}" method="POST" class="mt-2">
            @csrf
            <button type="submit" style="background:none;border:none;cursor:pointer;font-size:0.65rem;letter-spacing:0.1em;text-transform:uppercase;color:rgba(255,255,255,0.3);padding:0;">
                Logout
            </button>
        </form>
    </div>
</aside>

<!-- MAIN -->
<div class="admin-main">
    <div class="admin-topbar">
        <span class="topbar-title">@yield('topbar-title', 'Dashboard')</span>
        <div class="topbar-actions">
            @yield('topbar-actions')
        </div>
    </div>

    <div class="admin-page">
        @if(session('success'))
            <div class="admin-flash success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="admin-flash danger">{{ session('error') }}</div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
