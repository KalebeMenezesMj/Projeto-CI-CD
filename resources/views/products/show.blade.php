@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Início</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produtos</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index', ['categoria' => $product->category->slug]) }}">{{ $product->category->name }}</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        {{-- Imagem --}}
        <div class="col-lg-5">
            <div class="rounded-3 overflow-hidden shadow" style="height: 450px;">
                <img src="{{ $product->image ?: 'https://images.unsplash.com/photo-1490750967868-88df5691cc0c?w=600' }}"
                     class="w-100 h-100"
                     style="object-fit: cover;"
                     alt="{{ $product->name }}"
                     onerror="this.src='https://images.unsplash.com/photo-1490750967868-88df5691cc0c?w=600'">
            </div>
        </div>

        {{-- Detalhes --}}
        <div class="col-lg-7">
            <span class="badge bg-secondary mb-2">{{ $product->category->name }}</span>
            <h1 class="h2 fw-bold mb-3">{{ $product->name }}</h1>

            {{-- Preço --}}
            <div class="mb-4">
                @if($product->has_promotion)
                    <div>
                        <span class="text-muted text-decoration-line-through me-2" style="font-size: 1.1rem;">
                            R$ {{ number_format($product->price, 2, ',', '.') }}
                        </span>
                        <span class="badge-promo">-{{ $product->discount_percentage }}% OFF</span>
                    </div>
                    <div class="price-current mt-1" style="font-size: 2rem;">
                        R$ {{ number_format($product->promotional_price, 2, ',', '.') }}
                    </div>
                @else
                    <div class="price-current" style="font-size: 2rem;">
                        R$ {{ number_format($product->price, 2, ',', '.') }}
                    </div>
                @endif
                <small class="text-muted">
                    ou 3x de R$ {{ number_format($product->current_price / 3, 2, ',', '.') }} sem juros
                </small>
            </div>

            {{-- Estoque --}}
            @if($product->stock > 0)
                <div class="d-flex align-items-center gap-2 mb-3">
                    <i class="fas fa-check-circle text-success"></i>
                    <span class="text-success fw-bold">Em estoque</span>
                    <span class="text-muted small">({{ $product->stock }} disponíveis)</span>
                </div>
            @else
                <div class="d-flex align-items-center gap-2 mb-3">
                    <i class="fas fa-times-circle text-danger"></i>
                    <span class="text-danger fw-bold">Produto esgotado</span>
                </div>
            @endif

            {{-- Add ao Carrinho --}}
            @if($product->stock > 0)
            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <label class="fw-bold">Quantidade:</label>
                    <div class="input-group" style="width: 130px;">
                        <button type="button" class="btn btn-outline-secondary" onclick="changeQty(-1)">-</button>
                        <input type="number" name="quantity" id="qty" value="1" min="1" max="{{ $product->stock }}" class="form-control text-center">
                        <button type="button" class="btn btn-outline-secondary" onclick="changeQty(1)">+</button>
                    </div>
                </div>
                <div class="d-flex flex-wrap gap-3">
                    <button type="submit" class="btn btn-floral btn-lg">
                        <i class="fas fa-cart-plus me-2"></i>Adicionar ao Carrinho
                    </button>
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-floral btn-lg">
                        <i class="fas fa-shopping-bag me-2"></i>Ver Carrinho
                    </a>
                </div>
            </form>
            @endif

            <hr>

            {{-- Garantias --}}
            <div class="row g-3 mt-2">
                <div class="col-4 text-center">
                    <i class="fas fa-truck text-floral fa-2x mb-1"></i>
                    <div class="small text-muted">Entrega rápida</div>
                </div>
                <div class="col-4 text-center">
                    <i class="fas fa-leaf text-success fa-2x mb-1"></i>
                    <div class="small text-muted">Flores frescas</div>
                </div>
                <div class="col-4 text-center">
                    <i class="fas fa-shield-alt text-primary fa-2x mb-1"></i>
                    <div class="small text-muted">Compra segura</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Descrição --}}
    @if($product->description)
    <div class="mt-5">
        <div class="card shadow-sm">
            <div class="card-header fw-bold">
                <i class="fas fa-info-circle me-2 text-floral"></i>Descrição do Produto
            </div>
            <div class="card-body">
                <p class="mb-0">{{ $product->description }}</p>
            </div>
        </div>
    </div>
    @endif

    {{-- Produtos Relacionados --}}
    @if($relatedProducts->count() > 0)
    <div class="mt-5">
        <h3 class="section-title mb-4">Produtos Relacionados</h3>
        <div class="row g-4">
            @foreach($relatedProducts as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function changeQty(delta) {
    const input = document.getElementById('qty');
    const max = parseInt(input.max);
    const newVal = parseInt(input.value) + delta;
    if (newVal >= 1 && newVal <= max) input.value = newVal;
}
</script>
@endpush
