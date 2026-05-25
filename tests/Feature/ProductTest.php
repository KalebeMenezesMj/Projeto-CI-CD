<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    private function createProduct(array $overrides = []): Product
    {
        $category = Category::create(['name' => 'Rosas', 'slug' => 'rosas']);
        return Product::create(array_merge([
            'category_id' => $category->id,
            'name' => 'Rosa Vermelha',
            'description' => 'Linda rosa vermelha',
            'price' => 29.90,
            'stock' => 10,
            'active' => true,
        ], $overrides));
    }

    public function test_products_page_returns_200(): void
    {
        $response = $this->get('/produtos');
        $response->assertStatus(200);
    }

    public function test_product_detail_returns_200_for_active_product(): void
    {
        $product = $this->createProduct();
        $response = $this->get("/produtos/{$product->slug}");
        $response->assertStatus(200);
    }

    public function test_inactive_product_returns_404(): void
    {
        $product = $this->createProduct(['name' => 'Rosa Inativa', 'active' => false]);
        $response = $this->get("/produtos/{$product->slug}");
        $response->assertStatus(404);
    }

    public function test_product_detail_shows_product_name(): void
    {
        $product = $this->createProduct(['name' => 'Rosa Especial']);
        $response = $this->get("/produtos/{$product->slug}");
        $response->assertSee('Rosa Especial');
    }

    public function test_products_page_filters_by_category(): void
    {
        $this->createProduct();
        $response = $this->get('/produtos?categoria=rosas');
        $response->assertStatus(200);
    }
}
