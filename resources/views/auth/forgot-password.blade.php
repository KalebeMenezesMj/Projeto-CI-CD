@extends('layouts.app')
@section('title', 'Esqueci minha Senha')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="text-center mb-4">
                <div style="font-size: 3rem;">🔑</div>
                <h2 class="fw-bold">Recuperar Senha</h2>
                <p class="text-muted">Informe seu e-mail para receber as instruções</p>
            </div>
            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-4">
                    @if(session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif
                    <form action="{{ route('password.email') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-bold">E-mail</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn btn-floral w-100">Enviar Link de Recuperação</button>
                    </form>
                </div>
            </div>
            <div class="text-center mt-3">
                <a href="{{ route('login') }}" class="text-floral">Voltar para login</a>
            </div>
        </div>
    </div>
</div>
@endsection
