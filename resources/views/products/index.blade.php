@extends('layouts.app')

@section('title', $currentCategory ? $currentCategory->name : 'Produtos')

@section('content')
<div class="container py-4">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Início</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produtos</a></li>
            @if($currentCategory)
                <li class="breadcrumb-item active">{{ $currentCategory->name }}</li>
            @endif
        </ol>
    </nav>

    <div class="row g-4">
        {{-- Filtros --}}
        <div class="col-lg-3">
            <div class="card shadow-sm">
                <div class="card-header" style="background: linear-gradient(135deg, #4a1942, #2d1b2e); color: white; border-radius: 12px 12px 0 0 !important;">
                    <h6 class="mb-0"><i class="fas fa-filter me-2"></i>Filtros</h6>
                </div>
                <div class="card-body p-3">
                    <form action="{{ route('products.index') }}" method="GET">
                        {{-- Busca --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Busca</label>
                            <input type="text" class="form-control" name="busca" placeholder="Nome do produto..." value="{{ request('busca') }}">
                        </div>

                        {{-- Categorias --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Categorias</label>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('products.index', array_merge(request()->except('categoria'), [])) }}"
                                   class="badge {{ !request('categoria') ? 'bg-floral' : 'bg-secondary' }} text-decoration-none">
                                    Todas
                                </a>
                                @foreach($categories as $cat)
                                    <a href="{{ route('products.index', array_merge(request()->except('categoria'), ['categoria' => $cat->slug])) }}"
                                       class="badge {{ request('categoria') == $cat->slug ? 'bg-floral' : 'bg-secondary' }} text-decoration-none">
                                        {{ $cat->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        {{-- Preço --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Faixa de Preço</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="number" class="form-control form-control-sm" name="preco_min" placeholder="Mín" value="{{ request('preco_min') }}" step="0.01" min="0">
                                </div>
                                <div class="col-6">
                                    <input type="number" class="form-control form-control-sm" name="preco_max" placeholder="Máx" value="{{ request('preco_max') }}" step="0.01" min="0">
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="categoria" value="{{ request('categoria') }}">
                        <button type="submit" class="btn btn-floral w-100 btn-sm">Filtrar</button>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100 btn-sm mt-2">Limpar</a>
                    </form>
                </div>
            </div>
        </div>

        {{-- Produtos --}}
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div>
                    <h4 class="mb-0">{{ $currentCategory ? $currentCategory->name : 'Todos os Produtos' }}</h4>
                    <small class="text-muted">{{ $products->total() }} produtos encontrados</small>
                </div>
                <form action="{{ route('products.index') }}" method="GET">
                    @foreach(request()->except('ordenar') as $key => $val)
                        <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                    @endforeach
                    <select name="ordenar" class="form-select form-select-sm" onchange="this.form.submit()" style="width: auto;">
                        <option value="latest" {{ request('ordenar') == 'latest' ? 'selected' : '' }}>Mais Recentes</option>
                        <option value="price_asc" {{ request('ordenar') == 'price_asc' ? 'selected' : '' }}>Menor Preço</option>
                        <option value="price_desc" {{ request('ordenar') == 'price_desc' ? 'selected' : '' }}>Maior Preço</option>
                        <option value="name" {{ request('ordenar') == 'name' ? 'selected' : '' }}>Nome A-Z</option>
                    </select>
                </form>
            </div>

            @if($products->isEmpty())
                <div class="text-center py-5">
                    <div style="font-size: 5rem;">🌵</div>
                    <h5 class="mt-3 text-muted">Nenhum produto encontrado</h5>
                    <p class="text-muted">Tente outros filtros ou <a href="{{ route('products.index') }}" class="text-floral">veja todos os produtos</a></p>
                </div>
            @else
                <div class="row g-4">
                    @foreach($products as $product)
                        @include('components.product-card', ['product' => $product])
                    @endforeach
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
