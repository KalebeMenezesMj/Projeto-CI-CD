@extends('layouts.app')

@section('title', 'Entrar')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="text-center mb-4">
                <div style="font-size: 3rem;">🌸</div>
                <h2 class="fw-bold">Entrar na sua conta</h2>
                <p class="text-muted">Bem-vindos(a) de volta à Flores & Sonhos</p>
            </div>

            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-4">
                    @if(session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">E-mail</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" placeholder="seu@email.com" required autofocus>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <label class="form-label fw-bold">Senha</label>
                                <a href="{{ route('password.request') }}" class="small text-floral">Esqueceu a senha?</a>
                            </div>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                   placeholder="••••••••" required>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-4 form-check">
                            <input type="checkbox" name="remember" id="remember" class="form-check-input">
                            <label for="remember" class="form-check-label">Lembrar de mim</label>
                        </div>
                        <button type="submit" class="btn btn-floral w-100 btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i>Entrar
                        </button>
                    </form>
                </div>
            </div>

            <div class="text-center mt-3">
                <span class="text-muted">Não tem conta? </span>
                <a href="{{ route('register') }}" class="text-floral fw-bold">Cadastre-se grátis</a>
            </div>
        </div>
    </div>
</div>
@endsection
