@extends('layouts.app')

@section('title', 'Criar Conta')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-center mb-4">
                <div style="font-size: 3rem;">🌺</div>
                <h2 class="fw-bold">Criar sua conta</h2>
                <p class="text-muted">Junte-se à família Flores & Sonhos</p>
            </div>

            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-4">
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nome completo</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" placeholder="Seu nome" required autofocus>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">E-mail</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" placeholder="seu@email.com" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Telefone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="(11) 99999-9999">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Senha</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Mínimo 8 caracteres" required>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Confirmar Senha</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Repita a senha" required>
                        </div>
                        <button type="submit" class="btn btn-floral w-100 btn-lg">
                            <i class="fas fa-user-plus me-2"></i>Criar Conta
                        </button>
                    </form>
                </div>
            </div>

            <div class="text-center mt-3">
                <span class="text-muted">Já tem conta? </span>
                <a href="{{ route('login') }}" class="text-floral fw-bold">Entrar</a>
            </div>
        </div>
    </div>
</div>
@endsection
