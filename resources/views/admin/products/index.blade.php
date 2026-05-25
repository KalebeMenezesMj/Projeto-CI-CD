@extends('layouts.admin')
@section('title', 'Produtos')
@section('page-title', 'Gerenciar Produtos')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-seedling me-2"></i>Produtos ({{ $products->total() }})</span>
        <a href="{{ route('admin.produtos.create') }}" class="btn btn-sm" style="background:#e91e8c;color:white;border-radius:8px;">
            <i class="fas fa-plus me-1"></i>Novo Produto
        </a>
    </div>
    <div class="card-body border-bottom">
        <form action="{{ route('admin.produtos.index') }}" method="GET" class="row g-2">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Buscar produto..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <select name="category_id" class="form-select form-select-sm">
                    <option value="">Todas categorias</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-sm btn-dark w-100">Filtrar</button>
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead><tr>
                    <th>Produto</th><th>Categoria</th><th>Preço</th><th>Estoque</th><th>Status</th><th>Ações</th>
                </tr></thead>
                <tbody>
                @forelse($products as $product)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <img src="{{ $product->image ?: 'https://images.unsplash.com/photo-1490750967868-88df5691cc0c?w=50' }}"
                                 width="40" height="40" style="object-fit:cover;border-radius:8px;"
                                 alt="{{ $product->name }}"
                                 onerror="this.src='https://images.unsplash.com/photo-1490750967868-88df5691cc0c?w=50'">
                            <div>
                                <div class="small fw-bold">{{ $product->name }}</div>
                                @if($product->featured)
                                    <span class="badge bg-warning text-dark" style="font-size:0.65rem;">Destaque</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="small">{{ $product->category->name ?? '-' }}</td>
                    <td class="small">
                        @if($product->promotional_price)
                            <del class="text-muted">R$ {{ number_format($product->price, 2, ',', '.') }}</del><br>
                            <span class="text-danger fw-bold">R$ {{ number_format($product->promotional_price, 2, ',', '.') }}</span>
                        @else
                            R$ {{ number_format($product->price, 2, ',', '.') }}
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $product->stock <= 5 ? 'bg-danger' : 'bg-success' }}">{{ $product->stock }}</span>
                    </td>
                    <td>
                        <span class="badge {{ $product->active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $product->active ? 'Ativo' : 'Inativo' }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.produtos.edit', $product) }}" class="btn btn-xs btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.produtos.destroy', $product) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-xs btn-sm btn-outline-danger" onclick="return confirm('Excluir produto?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-4 text-muted">Nenhum produto encontrado</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($products->hasPages())
    <div class="card-footer">{{ $products->links() }}</div>
    @endif
</div>
@endsection
