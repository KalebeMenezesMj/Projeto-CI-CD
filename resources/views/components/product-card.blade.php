<div class="col-sm-6 col-md-4 col-lg-3">
    <div class="product-card card h-100 shadow-sm">
        <div class="position-relative overflow-hidden" style="height: 220px;">
            <a href="{{ route('products.show', $product) }}">
                <img src="{{ $product->image ?: 'https://images.unsplash.com/photo-1490750967868-88df5691cc0c?w=400' }}"
                     class="card-img-top w-100 h-100"
                     style="object-fit: cover; transition: transform 0.4s;"
                     alt="{{ $product->name }}"
                     onerror="this.src='https://images.unsplash.com/photo-1490750967868-88df5691cc0c?w=400'"
                     onmouseover="this.style.transform='scale(1.08)'"
                     onmouseout="this.style.transform='scale(1)'">
            </a>
            @if($product->has_promotion)
                <span class="badge-promo position-absolute top-0 end-0 m-2">
                    -{{ $product->discount_percentage }}%
                </span>
            @endif
            @if($product->featured)
                <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-2" style="border-radius:20px;font-size:0.7rem;">
                    ⭐ Destaque
                </span>
            @endif
        </div>
        <div class="card-body d-flex flex-column p-3">
            <small class="text-muted mb-1">{{ $product->category->name ?? '' }}</small>
            <h6 class="card-title mb-2">
                <a href="{{ route('products.show', $product) }}" class="text-dark text-decoration-none">{{ $product->name }}</a>
            </h6>
            <div class="mt-auto">
                <div class="mb-2">
                    @if($product->has_promotion)
                        <span class="price-original">R$ {{ number_format($product->price, 2, ',', '.') }}</span><br>
                        <span class="price-current">R$ {{ number_format($product->promotional_price, 2, ',', '.') }}</span>
                    @else
                        <span class="price-current">R$ {{ number_format($product->price, 2, ',', '.') }}</span>
                    @endif
                </div>
                <div class="d-flex gap-2">
                    @if($product->stock > 0)
                        <form action="{{ route('cart.add') }}" method="POST" class="flex-grow-1">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-floral btn-sm w-100">
                                <i class="fas fa-cart-plus me-1"></i>Adicionar
                            </button>
                        </form>
                    @else
                        <button class="btn btn-secondary btn-sm w-100" disabled>Esgotado</button>
                    @endif
                    <a href="{{ route('products.show', $product) }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-eye"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
