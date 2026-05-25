<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Flores & Sonhos') - Floricultura</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --floral-pink: #e91e8c;
            --floral-rose: #f8bbd0;
            --floral-green: #4caf50;
            --floral-dark: #2d1b2e;
            --floral-cream: #fdf6f0;
        }
        body { font-family: 'Lato', sans-serif; background-color: var(--floral-cream); }
        h1, h2, h3, .brand-font { font-family: 'Playfair Display', serif; }

        /* Navbar */
        .navbar-floral { background: linear-gradient(135deg, #2d1b2e 0%, #4a1942 100%); }
        .navbar-brand { font-family: 'Playfair Display', serif; font-size: 1.8rem; color: #f8bbd0 !important; }
        .navbar-brand span { color: #e91e8c; }
        .nav-link { color: #f0d6e8 !important; transition: color 0.3s; }
        .nav-link:hover { color: #e91e8c !important; }
        .cart-badge { background: #e91e8c; color: white; border-radius: 50%; font-size: 0.7rem; padding: 2px 6px; position: relative; top: -8px; left: -4px; }

        /* Buttons */
        .btn-floral { background: linear-gradient(135deg, #e91e8c, #c2185b); color: white; border: none; border-radius: 25px; padding: 10px 28px; transition: all 0.3s; }
        .btn-floral:hover { background: linear-gradient(135deg, #c2185b, #ad1457); color: white; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(233,30,140,0.4); }
        .btn-outline-floral { border: 2px solid #e91e8c; color: #e91e8c; border-radius: 25px; padding: 8px 26px; transition: all 0.3s; background: transparent; }
        .btn-outline-floral:hover { background: #e91e8c; color: white; transform: translateY(-2px); }

        /* Cards */
        .product-card { border: none; border-radius: 15px; overflow: hidden; transition: transform 0.3s, box-shadow 0.3s; background: white; }
        .product-card:hover { transform: translateY(-8px); box-shadow: 0 15px 35px rgba(233,30,140,0.15); }
        .product-card .card-img-top { height: 220px; object-fit: cover; }
        .badge-promo { background: #e91e8c; color: white; border-radius: 20px; font-size: 0.75rem; padding: 3px 10px; }
        .price-original { text-decoration: line-through; color: #999; font-size: 0.9rem; }
        .price-current { color: #e91e8c; font-weight: 700; font-size: 1.1rem; }

        /* Hero */
        .hero-section { background: linear-gradient(135deg, #2d1b2e 0%, #4a1942 50%, #6a1f5e 100%); color: white; padding: 80px 0; position: relative; overflow: hidden; }
        .hero-section::before { content: '🌸'; font-size: 8rem; position: absolute; right: -20px; top: -20px; opacity: 0.1; }
        .hero-section::after { content: '🌺'; font-size: 6rem; position: absolute; left: -10px; bottom: -20px; opacity: 0.1; }

        /* Sections */
        .section-title { color: var(--floral-dark); position: relative; padding-bottom: 15px; }
        .section-title::after { content: ''; position: absolute; bottom: 0; left: 0; width: 60px; height: 3px; background: #e91e8c; border-radius: 2px; }
        .section-title.text-center::after { left: 50%; transform: translateX(-50%); }

        /* Category card */
        .category-card { border-radius: 15px; overflow: hidden; position: relative; height: 200px; cursor: pointer; }
        .category-card img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s; }
        .category-card:hover img { transform: scale(1.1); }
        .category-card .overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(45,27,46,0.85), transparent); display: flex; align-items: flex-end; padding: 20px; }
        .category-card .overlay h5 { color: white; font-family: 'Playfair Display', serif; margin: 0; }

        /* Footer */
        footer { background: linear-gradient(135deg, #2d1b2e, #4a1942); color: #f0d6e8; }
        footer a { color: #e91e8c; text-decoration: none; }
        footer a:hover { color: #f8bbd0; }

        /* Alerts */
        .alert { border-radius: 10px; border: none; }
        .alert-success { background: #e8f5e9; color: #2e7d32; }
        .alert-danger { background: #fce4ec; color: #c62828; }
        .alert-warning { background: #fff8e1; color: #e65100; }

        /* Forms */
        .form-control:focus, .form-select:focus { border-color: #e91e8c; box-shadow: 0 0 0 0.2rem rgba(233,30,140,0.2); }

        /* Breadcrumb */
        .breadcrumb-item a { color: #e91e8c; text-decoration: none; }
        .breadcrumb-item.active { color: #666; }

        /* Misc */
        .text-floral { color: #e91e8c; }
        .bg-floral { background-color: #e91e8c; }
        .border-floral { border-color: #e91e8c !important; }
    </style>
    @stack('styles')
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-floral sticky-top shadow">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            🌸 Flores<span>&</span>Sonhos
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <i class="fas fa-bars text-light"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}"><i class="fas fa-home me-1"></i>Início</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('products.index') }}"><i class="fas fa-leaf me-1"></i>Produtos</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="fas fa-tags me-1"></i>Categorias
                    </a>
                    <ul class="dropdown-menu">
                        @foreach(\App\Models\Category::where('active', true)->orderBy('order')->get() as $cat)
                            <li>
                                <a class="dropdown-item" href="{{ route('products.index', ['categoria' => $cat->slug]) }}">
                                    {{ $cat->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-3">
                {{-- Busca --}}
                <form action="{{ route('products.index') }}" method="GET" class="d-flex">
                    <div class="input-group" style="width: 220px;">
                        <input type="text" class="form-control form-control-sm" name="busca" placeholder="Buscar flores..." value="{{ request('busca') }}">
                        <button class="btn btn-sm btn-floral" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </form>

                {{-- Carrinho --}}
                @php
                    $cartCount = 0;
                    try {
                        if (auth()->check()) {
                            $c = \App\Models\Cart::where('user_id', auth()->id())->first();
                        } else {
                            $c = \App\Models\Cart::where('session_id', session()->getId())->first();
                        }
                        $cartCount = $c ? $c->items()->sum('quantity') : 0;
                    } catch (\Exception $e) {}
                @endphp
                <a href="{{ route('cart.index') }}" class="nav-link position-relative">
                    <i class="fas fa-shopping-bag fa-lg text-light"></i>
                    @if($cartCount > 0)
                        <span class="cart-badge">{{ $cartCount }}</span>
                    @endif
                </a>

                {{-- Auth --}}
                @auth
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-1" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle fa-lg"></i>
                            <span class="d-none d-lg-inline">{{ Str::words(auth()->user()->name, 1, '') }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.index') }}"><i class="fas fa-user me-2"></i>Meu Perfil</a></li>
                            <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i class="fas fa-box me-2"></i>Meus Pedidos</a></li>
                            @if(auth()->user()->is_admin)
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-floral" href="{{ route('admin.dashboard') }}"><i class="fas fa-shield-alt me-2"></i>Painel Admin</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i>Sair</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-floral btn-sm">Entrar</a>
                    <a href="{{ route('register') }}" class="btn btn-floral btn-sm">Cadastrar</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

{{-- Flash Messages --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <ul class="mb-0 mt-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@yield('content')

<footer class="mt-5 py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <h5 class="brand-font" style="color: #f8bbd0; font-size: 1.5rem;">🌸 Flores & Sonhos</h5>
                <p class="small opacity-75 mt-2">Levando beleza, amor e alegria através das mais lindas flores frescas. Sua floricutura de confiança desde 2010.</p>
                <div class="d-flex gap-3 mt-3">
                    <a href="#"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="#"><i class="fab fa-whatsapp fa-lg"></i></a>
                </div>
            </div>
            <div class="col-lg-2">
                <h6 class="text-white mb-3">Navegação</h6>
                <ul class="list-unstyled small">
                    <li class="mb-1"><a href="{{ route('home') }}">Início</a></li>
                    <li class="mb-1"><a href="{{ route('products.index') }}">Produtos</a></li>
                    <li class="mb-1"><a href="{{ route('cart.index') }}">Carrinho</a></li>
                    @auth
                        <li class="mb-1"><a href="{{ route('orders.index') }}">Meus Pedidos</a></li>
                    @else
                        <li class="mb-1"><a href="{{ route('login') }}">Entrar</a></li>
                    @endauth
                </ul>
            </div>
            <div class="col-lg-3">
                <h6 class="text-white mb-3">Categorias</h6>
                <ul class="list-unstyled small">
                    @foreach(\App\Models\Category::where('active', true)->orderBy('order')->take(5)->get() as $cat)
                        <li class="mb-1"><a href="{{ route('products.index', ['categoria' => $cat->slug]) }}">{{ $cat->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="col-lg-3">
                <h6 class="text-white mb-3">Contato</h6>
                <ul class="list-unstyled small opacity-75">
                    <li class="mb-2"><i class="fas fa-phone me-2" style="color: #e91e8c;"></i>(11) 3000-FLOR</li>
                    <li class="mb-2"><i class="fab fa-whatsapp me-2" style="color: #e91e8c;"></i>(11) 99000-FLOR</li>
                    <li class="mb-2"><i class="fas fa-envelope me-2" style="color: #e91e8c;"></i>contato@floresesonhos.com.br</li>
                    <li class="mb-2"><i class="fas fa-clock me-2" style="color: #e91e8c;"></i>Seg–Sáb: 8h às 19h | Dom: 8h às 14h</li>
                </ul>
                <div class="mt-3 d-flex gap-2">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/30/Mastercard-logo.svg/100px-Mastercard-logo.svg.png" height="20" alt="Mastercard">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/100px-Visa_Inc._logo.svg.png" height="20" alt="Visa">
                    <span class="badge bg-success">PIX</span>
                    <span class="badge bg-secondary">Boleto</span>
                </div>
            </div>
        </div>
        <hr class="my-4 opacity-25">
        <div class="row align-items-center">
            <div class="col text-center small opacity-50">
                &copy; {{ date('Y') }} Flores & Sonhos. Todos os direitos reservados. | Feito com ❤️ e muito amor pelas flores
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
