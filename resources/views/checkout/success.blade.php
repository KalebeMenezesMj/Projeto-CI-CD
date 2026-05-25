@extends('layouts.app')

@section('title', 'Pedido Confirmado!')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7 text-center">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div style="background: linear-gradient(135deg, #e91e8c, #c2185b); padding: 50px 20px;">
                    <div style="font-size: 5rem;">🌸</div>
                    <h2 class="text-white fw-bold mt-3">Pedido Confirmado!</h2>
                    <p class="text-white opacity-75 mb-0">Obrigado por comprar na Flores & Sonhos</p>
                </div>
                <div class="card-body p-4">
                    <div class="bg-light rounded-3 p-3 mb-4">
                        <div class="row g-3 text-start">
                            <div class="col-6">
                                <div class="small text-muted">Número do Pedido</div>
                                <div class="fw-bold text-floral fs-5">{{ $order->code }}</div>
                            </div>
                            <div class="col-6">
                                <div class="small text-muted">Status</div>
                                <span class="badge bg-warning text-dark">Pendente</span>
                            </div>
                            <div class="col-6">
                                <div class="small text-muted">Pagamento</div>
                                <div class="fw-bold">{{ $order->payment_label }}</div>
                            </div>
                            <div class="col-6">
                                <div class="small text-muted">Total</div>
                                <div class="fw-bold text-floral">R$ {{ number_format($order->total, 2, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>

                    <h6 class="fw-bold mb-3 text-start">Itens do Pedido:</h6>
                    <div class="text-start mb-4">
                        @foreach($order->items as $item)
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span>{{ $item->product_name }} <span class="text-muted">x{{ $item->quantity }}</span></span>
                            <span class="fw-bold">R$ {{ number_format($item->subtotal, 2, ',', '.') }}</span>
                        </div>
                        @endforeach
                        <div class="d-flex justify-content-between py-2 small text-muted">
                            <span>Frete</span>
                            <span>{{ $order->shipping > 0 ? 'R$ ' . number_format($order->shipping, 2, ',', '.') : 'GRÁTIS' }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-2 fw-bold fs-5">
                            <span>Total</span>
                            <span class="text-floral">R$ {{ number_format($order->total, 2, ',', '.') }}</span>
                        </div>
                    </div>

                    @if($order->payment_method === 'pix')
                    <div class="alert alert-success text-start">
                        <i class="fas fa-qrcode me-2"></i>
                        <strong>Pagamento via PIX:</strong> Em breve você receberá o código PIX por e-mail.
                    </div>
                    @elseif($order->payment_method === 'boleto')
                    <div class="alert alert-warning text-start">
                        <i class="fas fa-barcode me-2"></i>
                        <strong>Pagamento via Boleto:</strong> O boleto vence em 3 dias úteis. Será enviado para seu e-mail.
                    </div>
                    @endif

                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-floral">
                            <i class="fas fa-box me-2"></i>Acompanhar Pedido
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-home me-2"></i>Ir para Início
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
