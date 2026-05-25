@extends('layouts.admin')
@section('title', 'Pedido ' . $order->code)
@section('page-title', 'Detalhe do Pedido')

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        {{-- Info Pedido --}}
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-shopping-bag me-2"></i>Pedido <strong>{{ $order->code }}</strong></span>
                <span class="badge bg-{{ $order->status_color }} fs-6">{{ $order->status_label }}</span>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead><tr><th>Produto</th><th>Qtd</th><th>Preço</th><th>Subtotal</th></tr></thead>
                    <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>R$ {{ number_format($item->product_price, 2, ',', '.') }}</td>
                        <td>R$ {{ number_format($item->subtotal, 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-light">
                            <td colspan="3" class="text-end fw-bold">Subtotal</td>
                            <td>R$ {{ number_format($order->subtotal, 2, ',', '.') }}</td>
                        </tr>
                        <tr class="table-light">
                            <td colspan="3" class="text-end fw-bold">Frete</td>
                            <td>{{ $order->shipping > 0 ? 'R$ ' . number_format($order->shipping, 2, ',', '.') : 'GRÁTIS' }}</td>
                        </tr>
                        <tr class="table-light fw-bold">
                            <td colspan="3" class="text-end" style="color:#e91e8c;">TOTAL</td>
                            <td style="color:#e91e8c;">R$ {{ number_format($order->total, 2, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- Endereço --}}
        <div class="card mb-4">
            <div class="card-header fw-bold"><i class="fas fa-map-marker-alt me-2"></i>Endereço de Entrega</div>
            <div class="card-body small">
                <p class="fw-bold">{{ $order->shipping_name }}</p>
                <p>{{ $order->shipping_address }}, {{ $order->shipping_number }} {{ $order->shipping_complement ? '- '.$order->shipping_complement : '' }}<br>
                {{ $order->shipping_neighborhood }} — {{ $order->shipping_city }}/{{ $order->shipping_state }}<br>
                CEP: {{ $order->shipping_zipcode }}<br>
                Tel: {{ $order->shipping_phone }}</p>
                @if($order->notes)
                    <p class="mb-0"><strong>Obs:</strong> {{ $order->notes }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        {{-- Cliente --}}
        <div class="card mb-4">
            <div class="card-header fw-bold"><i class="fas fa-user me-2"></i>Cliente</div>
            <div class="card-body small">
                <p class="fw-bold mb-1">{{ $order->user->name }}</p>
                <p class="text-muted mb-0">{{ $order->user->email }}</p>
                <p class="text-muted">{{ $order->user->phone ?? 'Sem telefone' }}</p>
            </div>
        </div>

        {{-- Atualizar Status --}}
        <div class="card mb-4">
            <div class="card-header fw-bold"><i class="fas fa-edit me-2"></i>Atualizar Status</div>
            <div class="card-body">
                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                    @csrf @method('PATCH')
                    <select name="status" class="form-select mb-3">
                        @foreach(\App\Models\Order::statusLabels() as $key => $label)
                            <option value="{{ $key }}" {{ $order->status == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-sm w-100" style="background:#e91e8c;color:white;">Atualizar Status</button>
                </form>
            </div>
        </div>

        {{-- Atualizar Pagamento --}}
        <div class="card mb-4">
            <div class="card-header fw-bold"><i class="fas fa-credit-card me-2"></i>Status do Pagamento</div>
            <div class="card-body">
                <p class="small mb-2">Método: {{ $order->payment_label }}</p>
                <form action="{{ route('admin.orders.update-payment', $order) }}" method="POST">
                    @csrf @method('PATCH')
                    <select name="payment_status" class="form-select mb-3">
                        @foreach(['pending'=>'Aguardando','paid'=>'Pago','failed'=>'Falhou','refunded'=>'Estornado'] as $key => $label)
                            <option value="{{ $key }}" {{ $order->payment_status == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-sm btn-success w-100">Atualizar Pagamento</button>
                </form>
            </div>
        </div>

        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary w-100">
            <i class="fas fa-arrow-left me-2"></i>Voltar à Lista
        </a>
    </div>
</div>
@endsection
