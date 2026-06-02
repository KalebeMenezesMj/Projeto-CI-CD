@extends('layouts.app')

@section('title', 'Início')

@section('content')

{{-- Hero --}}
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <p class="text-uppercase small mb-2" style="color: #e91e8c; letter-spacing: 3px;">Teste</p>
                <h1 class="display-4 fw-bold mb-3" style="color: white; line-height: 1.2;">
                    Flores que Falam<br>
                    <span style="color: #f8bbd0;">o que as Palavras</span><br>
                    Não Conseguem
                </h1>
                <p class="lead mb-4" style="color: #d0a8c8;">
                    Escolha entre centenas de flores frescas e arranjos exclusivos. Entrega rápida e flores sempre frescas.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('products.index') }}" class="btn btn-floral btn-lg">
                        <i class="fas fa-leaf me-2"></i>Ver Produtos
                    </a>
                    <a href="{{ route('products.index', ['busca' => 'buque']) }}" class="btn btn-outline-floral btn-lg" style="border-color: #f8bbd0; color: #f8bbd0;">
                        <i class="fas fa-heart me-2"></i>Buquês Especiais
                    </a>
                </div>
                <div class="row mt-4 g-3">
                    <div class="col-auto">
                        <div class="d-flex align-items-center gap-2" style="color: #d0a8c8;">
                            <i class="fas fa-truck" style="color: #e91e8c;"></i>
                            <span class="small">Frete grátis acima de R$150</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="d-flex align-items-center gap-2" style="color: #d0a8c8;">
                            <i class="fas fa-check-circle" style="color: #e91e8c;"></i>
                            <span class="small">Flores frescas garantidas</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="d-flex align-items-center gap-2" style="color: #d0a8c8;">
                            <i class="fas fa-star" style="color: #e91e8c;"></i>
                            <span class="small">+5000 clientes satisfeitos</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 text-center d-none d-lg-block">
                <div style="font-size: 12rem; line-height: 1; filter: drop-shadow(0 0 30px rgba(233,30,140,0.3));">🌺</div>
            </div>
        </div>
    </div>
</section>

{{-- Categorias --}}
<section class="py-5">
    <div class="container">
        <h2 class="section-title text-center mb-4">Explore por Categoria</h2>
        <div class="row g-3 mt-2">
            @foreach($categories as $category)
            <div class="col-6 col-md-4 col-lg-2">
                <a href="{{ route('products.index', ['categoria' => $category->slug]) }}" class="text-decoration-none">
                    <div class="category-card shadow-sm">
                        <img src="{{ $category->image ?: 'https://images.unsplash.com/photo-1490750967868-88df5691cc0c?w=400' }}"
                             alt="{{ $category->name }}"
                             onerror="this.src='https://images.unsplash.com/photo-1490750967868-88df5691cc0c?w=400'">
                        <div class="overlay">
                            <div>
                                <h5 class="mb-0">{{ $category->name }}</h5>
                                <small style="color: rgba(255,255,255,0.7);">{{ $category->active_products_count }} produtos</small>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Produtos em Destaque --}}
@if($featuredProducts->count() > 0)
<section class="py-5" style="background: white;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="section-title">Destaques da Semana</h2>
                <p class="text-muted mt-2">Nossas flores mais amadas por nossos clientes</p>
            </div>
            <a href="{{ route('products.index', ['ordenar' => 'latest']) }}" class="btn btn-outline-floral">Ver todos</a>
        </div>
        <div class="row g-4">
            @foreach($featuredProducts as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Banner Frete Grátis --}}
<section class="py-4" style="background: linear-gradient(135deg, #e91e8c, #c2185b);">
    <div class="container">
        <div class="row align-items-center text-white text-center text-md-start">
            <div class="col-md-8">
                <h4 class="mb-1 fw-bold">🚚 Frete Grátis em compras acima de R$ 150,00!</h4>
                <p class="mb-0 opacity-75">Entregamos flores frescas na sua cidade com agilidade e cuidado.</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="{{ route('products.index') }}" class="btn btn-light btn-lg text-floral fw-bold">
                    Comprar Agora
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Lançamentos --}}
@if($newProducts->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="section-title">Novidades</h2>
                <p class="text-muted mt-2">Acabaram de chegar na nossa floricultura</p>
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-outline-floral">Ver todos</a>
        </div>
        <div class="row g-4">
            @foreach($newProducts as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Por que nos escolher --}}
<section class="py-5" style="background: var(--floral-dark);">
    <div class="container">
        <h2 class="section-title text-center text-white mb-5">Por que escolher a Flores & Sonhos?</h2>
        <div class="row g-4 text-center">
            <div class="col-md-3">
                <div class="p-4">
                    <div style="font-size: 3rem;">🌿</div>
                    <h5 class="text-white mt-3">Flores Frescas</h5>
                    <p class="text-muted small">Selecionamos as flores mais frescas diariamente para garantir qualidade.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-4">
                    <div style="font-size: 3rem;">🚚</div>
                    <h5 class="text-white mt-3">Entrega Rápida</h5>
                    <p class="text-muted small">Entregamos no mesmo dia para pedidos realizados até as 15h.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-4">
                    <div style="font-size: 3rem;">💳</div>
                    <h5 class="text-white mt-3">Pagamento Seguro</h5>
                    <p class="text-muted small">Aceitamos cartão, PIX e boleto com total segurança.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-4">
                    <div style="font-size: 3rem;">💝</div>
                    <h5 class="text-white mt-3">Satisfação Garantida</h5>
                    <p class="text-muted small">Caso não fique satisfeito, devolvemos seu dinheiro.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
