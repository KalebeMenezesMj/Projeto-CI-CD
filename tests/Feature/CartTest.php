<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    private function createProduct(array $overrides = []): Product
    {
        $category = Category::create(['name' => 'Rosas', 'slug' => 'rosas']);

        return Product::create(array_merge([
            'category_id' => $category->id,
            'name' => 'Rosa Vermelha',
            'description' => 'Linda rosa',
            'price' => 29.90,
            'stock' => 10,
            'active' => true,
        ], $overrides));
    }

    public function test_cart_page_returns_200_for_guest(): void
    {
        $response = $this->get('/carrinho');
        $response->assertStatus(200);
    }

    public function test_guest_can_add_product_to_cart(): void
    {
        $product = $this->createProduct();
        $response = $this->post('/carrinho/adicionar', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    public function test_cannot_add_inactive_product_to_cart(): void
    {
        $product = $this->createProduct(['name' => 'Rosa Inativa', 'active' => false]);
        $response = $this->post('/carrinho/adicionar', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    public function test_cannot_add_product_exceeding_stock(): void
    {
        $product = $this->createProduct(['stock' => 2]);
        $response = $this->post('/carrinho/adicionar', [
            'product_id' => $product->id,
            'quantity' => 99,
        ]);
        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    public function test_add_to_cart_requires_valid_product_id(): void
    {
        $response = $this->post('/carrinho/adicionar', [
            'product_id' => 9999,
            'quantity' => 1,
        ]);
        $response->assertSessionHasErrors('product_id');
    }
}
