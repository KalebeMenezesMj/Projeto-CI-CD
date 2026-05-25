<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - @yield('title', 'Painel') | Flores & Sonhos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Lato', sans-serif; background: #f4f6f9; }
        .sidebar { background: linear-gradient(180deg, #2d1b2e, #4a1942); min-height: 100vh; width: 260px; position: fixed; left: 0; top: 0; z-index: 1000; transition: transform 0.3s; }
        .sidebar-brand { padding: 20px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-brand a { color: #f8bbd0; text-decoration: none; font-size: 1.3rem; font-weight: 700; }
        .sidebar-brand span { color: #e91e8c; }
        .sidebar-nav { padding: 20px 0; }
        .nav-section { padding: 8px 20px 4px; color: rgba(255,255,255,0.4); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; }
        .sidebar .nav-link { color: rgba(255,255,255,0.75); padding: 10px 20px; display: flex; align-items: center; gap: 10px; border-radius: 0; transition: all 0.2s; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: rgba(233,30,140,0.2); color: #e91e8c; border-left: 3px solid #e91e8c; }
        .sidebar .nav-link i { width: 20px; text-align: center; }
        .main-content { margin-left: 260px; padding: 0; }
        .topbar { background: white; padding: 15px 25px; display: flex; justify-content: between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .content-area { padding: 25px; }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .card-header { background: white; border-bottom: 1px solid #f0f0f0; font-weight: 600; padding: 15px 20px; border-radius: 12px 12px 0 0 !important; }
        .stat-card { border-radius: 12px; color: white; padding: 20px; }
        .table th { background: #f8f9fa; font-weight: 600; font-size: 0.85rem; color: #666; border: none; }
        .table td { vertical-align: middle; border-color: #f0f0f0; }
        .btn-sm { border-radius: 6px; }
        .badge { font-size: 0.75rem; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main-content { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

<div class="sidebar">
    <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}">🌸 Flores<span>&</span>Sonhos<br><small style="font-size:0.75rem;opacity:0.7">Painel Admin</small></a>
    </div>
    <div class="sidebar-nav">
        <div class="nav-section">Visão Geral</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>

        <div class="nav-section mt-3">Catálogo</div>
        <a href="{{ route('admin.produtos.index') }}" class="nav-link {{ request()->routeIs('admin.produtos.*') ? 'active' : '' }}">
            <i class="fas fa-seedling"></i> Produtos
        </a>
        <a href="{{ route('admin.categorias.index') }}" class="nav-link {{ request()->routeIs('admin.categorias.*') ? 'active' : '' }}">
            <i class="fas fa-tags"></i> Categorias
        </a>

        <div class="nav-section mt-3">Vendas</div>
        <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="fas fa-shopping-bag"></i> Pedidos
        </a>

        <div class="nav-section mt-3">Sistema</div>
        <a href="{{ route('home') }}" class="nav-link" target="_blank">
            <i class="fas fa-external-link-alt"></i> Ver Loja
        </a>
        <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                <i class="fas fa-sign-out-alt"></i> Sair
            </button>
        </form>
    </div>
</div>

<div class="main-content">
    <div class="topbar d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold text-dark">@yield('page-title', 'Dashboard')</h6>
        <div class="d-flex align-items-center gap-3">
            <span class="text-muted small">Bem-vindo(a), <strong>{{ auth()->user()->name }}</strong></span>
            <div class="rounded-circle bg-pink d-flex align-items-center justify-content-center" style="width:36px;height:36px;background:#e91e8c;color:white;font-weight:700;">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
        </div>
    </div>

    <div class="content-area">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
