@extends('layouts.admin')
@section('title', 'Editar Categoria')
@section('page-title', 'Editar Categoria')

@section('content')
<div class="card" style="max-width: 700px;">
    <div class="card-header">
        <a href="{{ route('admin.categorias.index') }}" class="btn btn-sm btn-outline-secondary me-2"><i class="fas fa-arrow-left"></i></a>
        Editar: {{ $category->name }}
    </div>
    <div class="card-body">
        <form action="{{ route('admin.categorias.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-bold">Nome *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Descrição</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
            </div>
            <div class="mb-3">
                @if($category->image)
                    <div class="mb-2">
                        <img src="{{ str_starts_with($category->image, 'http') ? $category->image : asset('storage/' . $category->image) }}"
                             width="100" height="100" style="object-fit:cover;border-radius:8px;" alt="">
                    </div>
                @endif
                <label class="form-label fw-bold">{{ $category->image ? 'Trocar Imagem' : 'Imagem' }}</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Ordem</label>
                <input type="number" name="order" class="form-control" value="{{ old('order', $category->order) }}" min="0" style="max-width:120px;">
            </div>
            <div class="form-check mb-4">
                <input type="checkbox" name="active" value="1" id="active" class="form-check-input" {{ $category->active ? 'checked' : '' }}>
                <label for="active" class="form-check-label">Categoria Ativa</label>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn" style="background:#e91e8c;color:white;"><i class="fas fa-save me-2"></i>Atualizar</button>
                <a href="{{ route('admin.categorias.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
