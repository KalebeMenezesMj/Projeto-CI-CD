@extends('layouts.app')

@section('title', 'Carrinho de Compras')

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Início</a></li>
            <li class="breadcrumb-item active">Carrinho</li>
        </ol>
    </nav>

    <h2 class="section-title mb-4">Carrinho de Compras</h2>

    @if($cart->items->isEmpty())
        <div class="text-center py-5">
            <div style="font-size: 6rem;">🛒</div>
            <h4 class="mt-3 text-muted">Seu carrinho está vazio</h4>
            <p class="text-muted">Explore nossas flores e adicione produtos ao carrinho.</p>
            <a href="{{ route('products.index') }}" class="btn btn-floral btn-lg mt-2">
                <i class="fas fa-leaf me-2"></i>Ver Produtos
            </a>
        </div>
    @else
        <div class="row g-4">
            {{-- Itens --}}
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-shopping-bag me-2"></i>{{ $cart->total_items }} {{ Str::plural('item', $cart->total_items) }}</span>
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Esvaziar o carrinho?')">
                                <i class="fas fa-trash me-1"></i>Esvaziar
                            </button>
                        </form>
                    </div>
                    <div class="card-body p-0">
                        @foreach($cart->items as $item)
                        <div class="d-flex align-items-center p-3 border-bottom gap-3">
                            <img src="{{ $item->product->image ?: 'https://images.unsplash.com/photo-1490750967868-88df5691cc0c?w=100' }}"
                                 width="80" height="80"
                                 style="object-fit: cover; border-radius: 10px; flex-shrink: 0;"
                                 alt="{{ $item->product->name }}"
                                 onerror="this.src='https://images.unsplash.com/photo-1490750967868-88df5691cc0c?w=100'">

                            <div class="flex-grow-1">
                                <a href="{{ route('products.show', $item->product) }}" class="text-dark text-decoration-none fw-bold">
                                    {{ $item->product->name }}
                                </a>
                                <div class="small text-muted">{{ $item->product->category->name ?? '' }}</div>
                                <div class="price-current">R$ {{ number_format($item->price, 2, ',', '.') }}</div>
                            </div>

                            <div class="d-flex align-items-center gap-2">
                                <form action="{{ route('cart.update', $item) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <div class="input-group input-group-sm" style="width: 110px;">
                                        <button type="button" class="btn btn-outline-secondary" onclick="changeItemQty(this, -1)">-</button>
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}"
                                               class="form-control text-center qty-input" onchange="this.form.submit()">
                                        <button type="button" class="btn btn-outline-secondary" onclick="changeItemQty(this, 1)">+</button>
                                    </div>
                                </form>

                                <div class="text-end" style="min-width: 90px;">
                                    <div class="fw-bold text-floral">R$ {{ number_format($item->subtotal, 2, ',', '.') }}</div>
                                </div>

                                <form action="{{ route('cart.remove', $item) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Continuar Comprando
                    </a>
                </div>
            </div>

            {{-- Resumo --}}
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header fw-bold">
                        <i class="fas fa-receipt me-2"></i>Resumo do Pedido
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span>R$ {{ number_format($cart->total, 2, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Frete</span>
                            @if($cart->total >= 150)
                                <span class="text-success fw-bold">GRÁTIS</span>
                            @else
                                <span>R$ 15,00</span>
                            @endif
                        </div>
                        @if($cart->total < 150)
                            <div class="alert alert-warning py-2 px-3 small">
                                <i class="fas fa-truck me-1"></i>
                                Faltam <strong>R$ {{ number_format(150 - $cart->total, 2, ',', '.') }}</strong> para frete grátis!
                            </div>
                        @endif
                        <hr>
                        <div class="d-flex justify-content-between fw-bold fs-5">
                            <span>Total</span>
                            <span class="text-floral">
                                R$ {{ number_format($cart->total + ($cart->total >= 150 ? 0 : 15), 2, ',', '.') }}
                            </span>
                        </div>
                        <small class="text-muted">3x sem juros no cartão</small>

                        @auth
                            <a href="{{ route('checkout.index') }}" class="btn btn-floral w-100 mt-3 btn-lg">
                                <i class="fas fa-lock me-2"></i>Finalizar Compra
                            </a>
                        @else
                            <div class="mt-3">
                                <a href="{{ route('login') }}" class="btn btn-floral w-100 btn-lg">
                                    <i class="fas fa-sign-in-alt me-2"></i>Entrar para Comprar
                                </a>
                                <div class="text-center mt-2 small text-muted">
                                    Não tem conta? <a href="{{ route('register') }}" class="text-floral">Cadastre-se</a>
                                </div>
                            </div>
                        @endauth

                        <div class="mt-3 d-flex justify-content-center gap-3 flex-wrap">
                            <span class="text-muted small"><i class="fas fa-credit-card me-1"></i>Cartão</span>
                            <span class="text-muted small"><i class="fas fa-qrcode me-1"></i>PIX</span>
                            <span class="text-muted small"><i class="fas fa-barcode me-1"></i>Boleto</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function changeItemQty(btn, delta) {
    const input = btn.closest('.input-group').querySelector('.qty-input');
    const max = parseInt(input.max);
    const newVal = parseInt(input.value) + delta;
    if (newVal >= 1 && newVal <= max) {
        input.value = newVal;
        input.form.submit();
    }
}
</script>
@endpush
