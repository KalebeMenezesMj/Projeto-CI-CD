@extends('layouts.admin')
@section('title', 'Categorias')
@section('page-title', 'Gerenciar Categorias')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-tags me-2"></i>Categorias</span>
        <a href="{{ route('admin.categorias.create') }}" class="btn btn-sm" style="background:#e91e8c;color:white;border-radius:8px;">
            <i class="fas fa-plus me-1"></i>Nova Categoria
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead><tr>
                <th>Imagem</th><th>Nome</th><th>Produtos</th><th>Ordem</th><th>Status</th><th>Ações</th>
            </tr></thead>
            <tbody>
            @forelse($categories as $category)
            <tr>
                <td>
                    <img src="{{ $category->image ?: 'https://images.unsplash.com/photo-1490750967868-88df5691cc0c?w=50' }}"
                         width="45" height="45" style="object-fit:cover;border-radius:8px;"
                         alt="{{ $category->name }}"
                         onerror="this.src='https://images.unsplash.com/photo-1490750967868-88df5691cc0c?w=50'">
                </td>
                <td>
                    <div class="fw-bold">{{ $category->name }}</div>
                    <div class="small text-muted">{{ Str::limit($category->description, 40) }}</div>
                </td>
                <td><span class="badge bg-primary">{{ $category->products_count }}</span></td>
                <td class="small text-muted">{{ $category->order }}</td>
                <td><span class="badge {{ $category->active ? 'bg-success' : 'bg-secondary' }}">{{ $category->active ? 'Ativa' : 'Inativa' }}</span></td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="{{ route('admin.categorias.edit', $category) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.categorias.destroy', $category) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Excluir categoria?')"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center py-4 text-muted">Nenhuma categoria encontrada</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
