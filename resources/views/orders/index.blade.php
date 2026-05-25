@extends('layouts.app')

@section('title', 'Meus Pedidos')

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Início</a></li>
            <li class="breadcrumb-item active">Meus Pedidos</li>
        </ol>
    </nav>

    <h2 class="section-title mb-4">Meus Pedidos</h2>

    @if($orders->isEmpty())
        <div class="text-center py-5">
            <div style="font-size: 5rem;">📦</div>
            <h5 class="mt-3 text-muted">Você ainda não fez nenhum pedido</h5>
            <a href="{{ route('products.index') }}" class="btn btn-floral mt-3">
                <i class="fas fa-leaf me-2"></i>Explorar Produtos
            </a>
        </div>
    @else
        <div class="row g-3">
            @foreach($orders as $order)
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                            <div>
                                <span class="fw-bold text-floral">{{ $order->code }}</span>
                                <div class="small text-muted mt-1">
                                    {{ $order->created_at->format('d/m/Y \à\s H:i') }} •
                                    {{ $order->items->count() }} {{ Str::plural('item', $order->items->count()) }}
                                </div>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-{{ $order->status_color }} mb-1">{{ $order->status_label }}</span>
                                <div class="fw-bold text-floral">R$ {{ number_format($order->total, 2, ',', '.') }}</div>
                            </div>
                        </div>
                        <hr class="my-3">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div class="d-flex gap-3 small text-muted">
                                <span><i class="fas fa-credit-card me-1"></i>{{ $order->payment_label }}</span>
                                <span><i class="fas fa-circle me-1" style="color: {{ $order->payment_status == 'paid' ? '#4caf50' : ($order->payment_status == 'pending' ? '#ff9800' : '#f44336') }};"></i>
                                    {{ ['pending'=>'Aguardando pagamento','paid'=>'Pago','failed'=>'Falhou','refunded'=>'Estornado'][$order->payment_status] ?? $order->payment_status }}
                                </span>
                            </div>
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-floral btn-sm">
                                Ver Detalhes <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-4 d-flex justify-content-center">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
