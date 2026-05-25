@extends('layouts.app')
@section('title', 'Meu Perfil')
@section('content')
<div class="container py-4">
    <h2 class="section-title mb-4">Meu Perfil</h2>
    <div class="row g-4">
        {{-- Dados Pessoais --}}
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header fw-bold"><i class="fas fa-user me-2 text-floral"></i>Dados Pessoais</div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Nome</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">E-mail</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Telefone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                        </div>
                        <hr>
                        <h6 class="fw-bold mb-3">Alterar Senha (opcional)</h6>
                        <div class="mb-3">
                            <label class="form-label">Senha Atual</label>
                            <input type="password" name="current_password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nova Senha</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirmar Nova Senha</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-floral">Salvar Alterações</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Endereços --}}
        <div class="col-lg-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header fw-bold d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-map-marker-alt me-2 text-floral"></i>Meus Endereços</span>
                </div>
                <div class="card-body">
                    @if($addresses->isEmpty())
                        <p class="text-muted small text-center py-2">Nenhum endereço cadastrado.</p>
                    @else
                        @foreach($addresses as $address)
                        <div class="border rounded p-3 mb-2 {{ $address->is_default ? 'border-floral' : '' }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="small">
                                    <div class="fw-bold">{{ $address->name }} {{ $address->is_default ? '<span class="badge badge-promo ms-1">Padrão</span>' : '' }}</div>
                                    <div class="text-muted">{{ $address->address }}, {{ $address->number }}{{ $address->complement ? ' - '.$address->complement : '' }}</div>
                                    <div class="text-muted">{{ $address->neighborhood }} - {{ $address->city }}/{{ $address->state }}</div>
                                    <div class="text-muted">CEP: {{ $address->zipcode }}</div>
                                </div>
                                <form action="{{ route('profile.addresses.destroy', $address) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Remover endereço?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    @endif

                    <hr>
                    <h6 class="fw-bold mb-3">Adicionar Endereço</h6>
                    <form action="{{ route('profile.addresses.store') }}" method="POST">
                        @csrf
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="text" name="name" class="form-control form-control-sm" placeholder="Nome *" required>
                            </div>
                            <div class="col-6">
                                <input type="text" name="phone" class="form-control form-control-sm" placeholder="Telefone *" required>
                            </div>
                            <div class="col-4">
                                <input type="text" name="zipcode" id="new_cep" class="form-control form-control-sm" placeholder="CEP *" required maxlength="9">
                            </div>
                            <div class="col-8">
                                <input type="text" name="address" id="new_address" class="form-control form-control-sm" placeholder="Endereço *" required>
                            </div>
                            <div class="col-4">
                                <input type="text" name="number" class="form-control form-control-sm" placeholder="Número *" required>
                            </div>
                            <div class="col-8">
                                <input type="text" name="complement" class="form-control form-control-sm" placeholder="Complemento">
                            </div>
                            <div class="col-12">
                                <input type="text" name="neighborhood" id="new_neighborhood" class="form-control form-control-sm" placeholder="Bairro *" required>
                            </div>
                            <div class="col-8">
                                <input type="text" name="city" id="new_city" class="form-control form-control-sm" placeholder="Cidade *" required>
                            </div>
                            <div class="col-4">
                                <input type="text" name="state" id="new_state" class="form-control form-control-sm" placeholder="UF *" required maxlength="2">
                            </div>
                            <div class="col-12 form-check">
                                <input type="checkbox" name="is_default" value="1" class="form-check-input" id="default_addr">
                                <label for="default_addr" class="form-check-label small">Usar como padrão</label>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-floral btn-sm w-100">Salvar Endereço</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('new_cep').addEventListener('blur', function() {
    const cep = this.value.replace(/\D/g, '');
    if (cep.length === 8) {
        fetch(`https://viacep.com.br/ws/${cep}/json/`).then(r => r.json()).then(data => {
            if (!data.erro) {
                document.getElementById('new_address').value = data.logradouro;
                document.getElementById('new_neighborhood').value = data.bairro;
                document.getElementById('new_city').value = data.localidade;
                document.getElementById('new_state').value = data.uf;
            }
        });
    }
});
</script>
@endpush
