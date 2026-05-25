@extends('layouts.app')

@section('title', 'Pedido ' . $order->code)

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Início</a></li>
            <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Meus Pedidos</a></li>
            <li class="breadcrumb-item active">{{ $order->code }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-lg-8">
            {{-- Status --}}
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                        <div>
                            <h4 class="fw-bold text-floral mb-1">Pedido {{ $order->code }}</h4>
                            <p class="text-muted small mb-0">Realizado em {{ $order->created_at->format('d/m/Y \à\s H:i') }}</p>
                        </div>
                        <span class="badge bg-{{ $order->status_color }} fs-6">{{ $order->status_label }}</span>
                    </div>

                    {{-- Timeline --}}
                    <div class="mt-4">
                        @php
                            $steps = ['pending' => 1, 'processing' => 2, 'shipped' => 3, 'delivered' => 4];
                            $currentStep = $steps[$order->status] ?? 0;
                        @endphp
                        <div class="d-flex justify-content-between position-relative" style="z-index: 1;">
                            <div style="position:absolute;top:20px;left:10%;right:10%;height:2px;background:#ddd;z-index:-1;"></div>
                            @foreach(['Pedido' => '📋', 'Processando' => '⚙️', 'Enviado' => '🚚', 'Entregue' => '✅'] as $label => $icon)
                            @php $step = ['Pedido' => 1, 'Processando' => 2, 'Enviado' => 3, 'Entregue' => 4][$label]; @endphp
                            <div class="text-center" style="width:22%">
                                <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center mb-2"
                                     style="width:40px;height:40px;background:{{ $currentStep >= $step ? '#e91e8c' : '#ddd' }};font-size:1rem;">
                                    {{ $icon }}
                                </div>
                                <small class="fw-bold {{ $currentStep >= $step ? 'text-floral' : 'text-muted' }}">{{ $label }}</small>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Itens --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header fw-bold">
                    <i class="fas fa-box me-2"></i>Itens do Pedido
                </div>
                <div class="card-body p-0">
                    @foreach($order->items as $item)
                    <div class="d-flex align-items-center gap-3 p-3 border-bottom">
                        @if($item->product && $item->product->image)
                        <img src="{{ $item->product->image }}" width="60" height="60"
                             style="object-fit:cover;border-radius:8px;" alt="{{ $item->product_name }}"
                             onerror="this.src='https://images.unsplash.com/photo-1490750967868-88df5691cc0c?w=60'">
                        @endif
                        <div class="flex-grow-1">
                            <div class="fw-bold">{{ $item->product_name }}</div>
                            <div class="small text-muted">{{ $item->quantity }}x R$ {{ number_format($item->product_price, 2, ',', '.') }}</div>
                        </div>
                        <div class="fw-bold text-floral">R$ {{ number_format($item->subtotal, 2, ',', '.') }}</div>
                    </div>
                    @endforeach
                    <div class="p-3">
                        <div class="d-flex justify-content-between small text-muted mb-1">
                            <span>Subtotal</span><span>R$ {{ number_format($order->subtotal, 2, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between small text-muted mb-1">
                            <span>Frete</span><span>{{ $order->shipping > 0 ? 'R$ ' . number_format($order->shipping, 2, ',', '.') : 'GRÁTIS' }}</span>
                        </div>
                        <div class="d-flex justify-content-between fw-bold fs-5 mt-2">
                            <span>Total</span><span class="text-floral">R$ {{ number_format($order->total, 2, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            {{-- Entrega --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header fw-bold">
                    <i class="fas fa-map-marker-alt me-2"></i>Endereço de Entrega
                </div>
                <div class="card-body small">
                    <p class="fw-bold mb-1">{{ $order->shipping_name }}</p>
                    <p class="mb-1">{{ $order->shipping_address }}, {{ $order->shipping_number }}
                        {{ $order->shipping_complement ? "- {$order->shipping_complement}" : '' }}</p>
                    <p class="mb-1">{{ $order->shipping_neighborhood }}</p>
                    <p class="mb-1">{{ $order->shipping_city }}/{{ $order->shipping_state }}</p>
                    <p class="mb-0 text-muted">CEP: {{ $order->shipping_zipcode }}</p>
                </div>
            </div>

            {{-- Pagamento --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header fw-bold">
                    <i class="fas fa-credit-card me-2"></i>Pagamento
                </div>
                <div class="card-body small">
                    <p class="mb-1"><strong>Método:</strong> {{ $order->payment_label }}</p>
                    <p class="mb-0">
                        <strong>Status:</strong>
                        <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : ($order->payment_status == 'pending' ? 'warning' : 'danger') }}">
                            {{ ['pending'=>'Aguardando','paid'=>'Pago','failed'=>'Falhou','refunded'=>'Estornado'][$order->payment_status] ?? $order->payment_status }}
                        </span>
                    </p>
                </div>
            </div>

            @if($order->notes)
            <div class="card shadow-sm">
                <div class="card-header fw-bold"><i class="fas fa-comment me-2"></i>Observações</div>
                <div class="card-body small">{{ $order->notes }}</div>
            </div>
            @endif

            <div class="mt-3 d-flex flex-column gap-2">
                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Meus Pedidos
                </a>
                <a href="{{ route('products.index') }}" class="btn btn-floral">
                    <i class="fas fa-leaf me-2"></i>Continuar Comprando
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
