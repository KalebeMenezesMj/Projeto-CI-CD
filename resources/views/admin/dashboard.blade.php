@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- Stats --}}
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #e91e8c, #c2185b);">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="opacity-75 small">Total de Pedidos</div>
                    <div class="fs-3 fw-bold">{{ $stats['total_orders'] }}</div>
                </div>
                <i class="fas fa-shopping-bag fa-2x opacity-50"></i>
            </div>
            <div class="small opacity-75 mt-2">{{ $stats['pending_orders'] }} pendentes</div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #4caf50, #388e3c);">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="opacity-75 small">Receita Total</div>
                    <div class="fs-3 fw-bold">R$ {{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
                </div>
                <i class="fas fa-dollar-sign fa-2x opacity-50"></i>
            </div>
            <div class="small opacity-75 mt-2">Pedidos pagos</div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #2196f3, #1565c0);">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="opacity-75 small">Produtos Ativos</div>
                    <div class="fs-3 fw-bold">{{ $stats['total_products'] }}</div>
                </div>
                <i class="fas fa-seedling fa-2x opacity-50"></i>
            </div>
            <div class="small opacity-75 mt-2 {{ $stats['low_stock'] > 0 ? 'text-warning' : '' }}">
                @if($stats['low_stock'] > 0)
                    ⚠️ {{ $stats['low_stock'] }} com estoque baixo
                @else
                    Estoque OK
                @endif
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #ff9800, #e65100);">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="opacity-75 small">Clientes</div>
                    <div class="fs-3 fw-bold">{{ $stats['total_users'] }}</div>
                </div>
                <i class="fas fa-users fa-2x opacity-50"></i>
            </div>
            <div class="small opacity-75 mt-2">{{ $stats['total_categories'] }} categorias</div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Pedidos Recentes --}}
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-shopping-bag me-2 text-floral"></i>Pedidos Recentes</span>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary">Ver todos</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead><tr>
                            <th>Código</th><th>Cliente</th><th>Total</th><th>Status</th><th></th>
                        </tr></thead>
                        <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td><span class="fw-bold text-floral small">{{ $order->code }}</span></td>
                            <td class="small">{{ $order->user->name }}</td>
                            <td class="small fw-bold">R$ {{ number_format($order->total, 2, ',', '.') }}</td>
                            <td><span class="badge bg-{{ $order->status_color }}">{{ $order->status_label }}</span></td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Nenhum pedido ainda</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Top Produtos --}}
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-star me-2 text-floral"></i>Produtos Mais Vendidos</span>
                <a href="{{ route('admin.produtos.index') }}" class="btn btn-sm btn-outline-secondary">Ver todos</a>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($topProducts as $i => $product)
                    <div class="list-group-item d-flex align-items-center gap-3">
                        <span class="fw-bold text-muted" style="width:20px;">{{ $i+1 }}</span>
                        <div class="flex-grow-1">
                            <div class="small fw-bold">{{ Str::limit($product->name, 30) }}</div>
                            <div class="small text-muted">{{ $product->order_items_count }} vendas</div>
                        </div>
                        <span class="small fw-bold text-floral">R$ {{ number_format($product->price, 2, ',', '.') }}</span>
                    </div>
                    @empty
                    <div class="list-group-item text-center text-muted py-4">Nenhum dado ainda</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Ações Rápidas --}}
        <div class="card mt-4">
            <div class="card-header fw-bold"><i class="fas fa-bolt me-2 text-floral"></i>Ações Rápidas</div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.produtos.create') }}" class="btn btn-floral btn-sm">
                        <i class="fas fa-plus me-2"></i>Novo Produto
                    </a>
                    <a href="{{ route('admin.categorias.create') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-plus me-2"></i>Nova Categoria
                    </a>
                    <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="btn btn-warning btn-sm text-dark">
                        <i class="fas fa-clock me-2"></i>Ver Pedidos Pendentes ({{ $stats['pending_orders'] }})
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
