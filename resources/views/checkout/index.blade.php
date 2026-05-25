@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container py-4">
    <h2 class="section-title mb-4">Finalizar Compra</h2>

    <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
        @csrf
        <div class="row g-4">
            {{-- Endereço e Pagamento --}}
            <div class="col-lg-8">
                {{-- Endereço de Entrega --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header fw-bold">
                        <i class="fas fa-map-marker-alt me-2 text-floral"></i>Endereço de Entrega
                    </div>
                    <div class="card-body">
                        @if($addresses->count() > 0)
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Usar endereço salvo:</label>
                                <div class="row g-2">
                                    @foreach($addresses as $address)
                                    <div class="col-md-6">
                                        <div class="border rounded p-3 cursor-pointer address-card {{ $address->is_default ? 'border-floral' : '' }}"
                                             onclick="fillAddress({{ $address->toJson() }}, this)"
                                             style="cursor: pointer;">
                                            <div class="fw-bold small">{{ $address->name }}</div>
                                            <div class="small text-muted">{{ $address->address }}, {{ $address->number }}</div>
                                            <div class="small text-muted">{{ $address->city }}/{{ $address->state }} - CEP: {{ $address->zipcode }}</div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <hr>
                        @endif

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nome completo *</label>
                                <input type="text" name="shipping_name" class="form-control" value="{{ old('shipping_name', $defaultAddress?->name ?? $user->name) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Telefone *</label>
                                <input type="text" name="shipping_phone" class="form-control" value="{{ old('shipping_phone', $defaultAddress?->phone ?? $user->phone) }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">CEP *</label>
                                <input type="text" name="shipping_zipcode" id="cep" class="form-control" value="{{ old('shipping_zipcode', $defaultAddress?->zipcode) }}" required maxlength="9">
                            </div>
                            <div class="col-md-9">
                                <label class="form-label">Endereço *</label>
                                <input type="text" name="shipping_address" id="address" class="form-control" value="{{ old('shipping_address', $defaultAddress?->address) }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Número *</label>
                                <input type="text" name="shipping_number" class="form-control" value="{{ old('shipping_number', $defaultAddress?->number) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Complemento</label>
                                <input type="text" name="shipping_complement" class="form-control" value="{{ old('shipping_complement', $defaultAddress?->complement) }}">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">Bairro *</label>
                                <input type="text" name="shipping_neighborhood" id="neighborhood" class="form-control" value="{{ old('shipping_neighborhood', $defaultAddress?->neighborhood) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Cidade *</label>
                                <input type="text" name="shipping_city" id="city" class="form-control" value="{{ old('shipping_city', $defaultAddress?->city) }}" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Estado *</label>
                                <input type="text" name="shipping_state" id="state" class="form-control" value="{{ old('shipping_state', $defaultAddress?->state) }}" required maxlength="2">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pagamento --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header fw-bold">
                        <i class="fas fa-credit-card me-2 text-floral"></i>Forma de Pagamento
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="border rounded p-3 d-flex align-items-center gap-3 cursor-pointer" style="cursor: pointer;">
                                    <input type="radio" name="payment_method" value="credit_card" {{ old('payment_method', 'credit_card') == 'credit_card' ? 'checked' : '' }} required>
                                    <div>
                                        <i class="fas fa-credit-card fa-lg text-floral d-block mb-1"></i>
                                        <strong class="small">Cartão de Crédito</strong><br>
                                        <span class="text-muted" style="font-size: 0.75rem;">até 3x sem juros</span>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="border rounded p-3 d-flex align-items-center gap-3 cursor-pointer" style="cursor: pointer;">
                                    <input type="radio" name="payment_method" value="pix" {{ old('payment_method') == 'pix' ? 'checked' : '' }}>
                                    <div>
                                        <i class="fas fa-qrcode fa-lg text-success d-block mb-1"></i>
                                        <strong class="small">PIX</strong><br>
                                        <span class="text-muted" style="font-size: 0.75rem;">aprovação imediata</span>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="border rounded p-3 d-flex align-items-center gap-3 cursor-pointer" style="cursor: pointer;">
                                    <input type="radio" name="payment_method" value="boleto" {{ old('payment_method') == 'boleto' ? 'checked' : '' }}>
                                    <div>
                                        <i class="fas fa-barcode fa-lg text-secondary d-block mb-1"></i>
                                        <strong class="small">Boleto</strong><br>
                                        <span class="text-muted" style="font-size: 0.75rem;">vence em 3 dias</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Observações --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header fw-bold">
                        <i class="fas fa-comment me-2 text-floral"></i>Observações (opcional)
                    </div>
                    <div class="card-body">
                        <textarea name="notes" class="form-control" rows="3" placeholder="Alguma observação especial? Ex: mensagem para o cartão, horário preferido de entrega...">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Resumo --}}
            <div class="col-lg-4">
                <div class="card shadow-sm position-sticky" style="top: 80px;">
                    <div class="card-header fw-bold">
                        <i class="fas fa-receipt me-2"></i>Resumo do Pedido
                    </div>
                    <div class="card-body">
                        @foreach($cart->items as $item)
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <img src="{{ $item->product->image ?: 'https://images.unsplash.com/photo-1490750967868-88df5691cc0c?w=60' }}"
                                 width="50" height="50" style="object-fit:cover;border-radius:8px;"
                                 alt="{{ $item->product->name }}"
                                 onerror="this.src='https://images.unsplash.com/photo-1490750967868-88df5691cc0c?w=60'">
                            <div class="flex-grow-1">
                                <div class="small fw-bold">{{ Str::limit($item->product->name, 30) }}</div>
                                <div class="small text-muted">{{ $item->quantity }}x R$ {{ number_format($item->price, 2, ',', '.') }}</div>
                            </div>
                            <span class="small fw-bold">R$ {{ number_format($item->subtotal, 2, ',', '.') }}</span>
                        </div>
                        @endforeach

                        <hr>
                        <div class="d-flex justify-content-between small mb-1">
                            <span class="text-muted">Subtotal</span>
                            <span>R$ {{ number_format($cart->total, 2, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between small mb-2">
                            <span class="text-muted">Frete</span>
                            @if($cart->total >= 150)
                                <span class="text-success fw-bold">GRÁTIS</span>
                            @else
                                <span>R$ 15,00</span>
                            @endif
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total</span>
                            <span class="text-floral fs-5">
                                R$ {{ number_format($cart->total + ($cart->total >= 150 ? 0 : 15), 2, ',', '.') }}
                            </span>
                        </div>

                        <button type="submit" class="btn btn-floral w-100 mt-4 btn-lg">
                            <i class="fas fa-lock me-2"></i>Confirmar Pedido
                        </button>
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                            <i class="fas fa-arrow-left me-2"></i>Voltar ao Carrinho
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function fillAddress(address, el) {
    document.querySelectorAll('.address-card').forEach(c => c.classList.remove('border-floral'));
    el.classList.add('border-floral');
    document.querySelector('[name=shipping_name]').value = address.name;
    document.querySelector('[name=shipping_phone]').value = address.phone;
    document.querySelector('[name=shipping_zipcode]').value = address.zipcode;
    document.querySelector('[name=shipping_address]').value = address.address;
    document.querySelector('[name=shipping_number]').value = address.number;
    document.querySelector('[name=shipping_complement]').value = address.complement || '';
    document.querySelector('[name=shipping_neighborhood]').value = address.neighborhood;
    document.querySelector('[name=shipping_city]').value = address.city;
    document.querySelector('[name=shipping_state]').value = address.state;
}

// Auto busca CEP
document.getElementById('cep').addEventListener('blur', function() {
    const cep = this.value.replace(/\D/g, '');
    if (cep.length === 8) {
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(r => r.json())
            .then(data => {
                if (!data.erro) {
                    document.getElementById('address').value = data.logradouro;
                    document.getElementById('neighborhood').value = data.bairro;
                    document.getElementById('city').value = data.localidade;
                    document.getElementById('state').value = data.uf;
                }
            });
    }
});
</script>
@endpush
