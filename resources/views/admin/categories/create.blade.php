@extends('layouts.admin')
@section('title', 'Nova Categoria')
@section('page-title', 'Nova Categoria')

@section('content')
<div class="card" style="max-width: 700px;">
    <div class="card-header">
        <a href="{{ route('admin.categorias.index') }}" class="btn btn-sm btn-outline-secondary me-2"><i class="fas fa-arrow-left"></i></a>
        Nova Categoria
    </div>
    <div class="card-body">
        <form action="{{ route('admin.categorias.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold">Nome *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Descrição</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Imagem</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Ordem de exibição</label>
                    <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}" min="0">
                </div>
            </div>
            <div class="form-check mb-4">
                <input type="checkbox" name="active" value="1" id="active" class="form-check-input" {{ old('active', true) ? 'checked' : '' }}>
                <label for="active" class="form-check-label">Categoria Ativa</label>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn" style="background:#e91e8c;color:white;"><i class="fas fa-save me-2"></i>Salvar</button>
                <a href="{{ route('admin.categorias.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
