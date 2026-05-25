@extends('layouts.admin')
@section('title', 'Pedidos')
@section('page-title', 'Gerenciar Pedidos')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-shopping-bag me-2"></i>Pedidos ({{ $orders->total() }})</span>
    </div>
    <div class="card-body border-bottom">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-2">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Código, nome ou email..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <select name="status" class="form-select form-select-sm">
                    <option value="">Todos os status</option>
                    @foreach(\App\Models\Order::statusLabels() as $key => $label)
                        <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>{{ $label }}</option>
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
                    <th>Código</th><th>Cliente</th><th>Data</th><th>Total</th><th>Pagamento</th><th>Status</th><th></th>
                </tr></thead>
                <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><span class="fw-bold text-floral small">{{ $order->code }}</span></td>
                    <td class="small">{{ $order->user->name }}<br><span class="text-muted">{{ $order->user->email }}</span></td>
                    <td class="small">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td class="small fw-bold">R$ {{ number_format($order->total, 2, ',', '.') }}</td>
                    <td>
                        <div class="small">{{ $order->payment_label }}</div>
                        <span class="badge {{ $order->payment_status == 'paid' ? 'bg-success' : ($order->payment_status == 'pending' ? 'bg-warning text-dark' : 'bg-danger') }}" style="font-size:0.65rem;">
                            {{ ['pending'=>'Aguardando','paid'=>'Pago','failed'=>'Falhou','refunded'=>'Estornado'][$order->payment_status] ?? $order->payment_status }}
                        </span>
                    </td>
                    <td><span class="badge bg-{{ $order->status_color }}">{{ $order->status_label }}</span></td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-4 text-muted">Nenhum pedido encontrado</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($orders->hasPages())
    <div class="card-footer">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
