@extends('layouts.admin')
@section('title', 'Editar Produto')
@section('page-title', 'Editar Produto')

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('admin.produtos.index') }}" class="btn btn-sm btn-outline-secondary me-2"><i class="fas fa-arrow-left"></i></a>
        Editar: {{ $product->name }}
    </div>
    <div class="card-body">
        <form action="{{ route('admin.produtos.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nome do Produto *</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Descrição</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Preço *</label>
                            <div class="input-group">
                                <span class="input-group-text">R$</span>
                                <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" step="0.01" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Preço Promocional</label>
                            <div class="input-group">
                                <span class="input-group-text">R$</span>
                                <input type="number" name="promotional_price" class="form-control" value="{{ old('promotional_price', $product->promotional_price) }}" step="0.01" min="0">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Estoque *</label>
                            <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" min="0" required>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Categoria *</label>
                        <select name="category_id" class="form-select" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        @if($product->image)
                            <div class="mb-2">
                                <img src="{{ str_starts_with($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}"
                                     width="100" height="100" style="object-fit:cover;border-radius:8px;" alt="">
                            </div>
                        @endif
                        <label class="form-label fw-bold">{{ $product->image ? 'Trocar Imagem' : 'Imagem' }}</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <div class="form-check mb-2">
                        <input type="checkbox" name="featured" value="1" id="featured" class="form-check-input" {{ $product->featured ? 'checked' : '' }}>
                        <label for="featured" class="form-check-label">Produto em Destaque</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="active" value="1" id="active" class="form-check-input" {{ $product->active ? 'checked' : '' }}>
                        <label for="active" class="form-check-label">Produto Ativo</label>
                    </div>
                </div>
            </div>
            <hr>
            <div class="d-flex gap-2">
                <button type="submit" class="btn" style="background:#e91e8c;color:white;"><i class="fas fa-save me-2"></i>Atualizar</button>
                <a href="{{ route('admin.produtos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
