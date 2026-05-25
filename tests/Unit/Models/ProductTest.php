<?php

namespace Tests\Unit\Models;

use App\Models\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function test_current_price_returns_promotional_when_set(): void
    {
        $product = new Product([
            'price' => '100.00',
            'promotional_price' => '80.00',
        ]);
        $this->assertEquals('80.00', $product->current_price);
    }

    public function test_current_price_returns_regular_price_when_no_promo(): void
    {
        $product = new Product([
            'price' => '100.00',
            'promotional_price' => null,
        ]);
        $this->assertEquals('100.00', $product->current_price);
    }

    public function test_has_promotion_true_when_promo_less_than_price(): void
    {
        $product = new Product([
            'price' => '100.00',
            'promotional_price' => '80.00',
        ]);
        $this->assertTrue($product->has_promotion);
    }

    public function test_has_promotion_false_when_no_promotional_price(): void
    {
        $product = new Product([
            'price' => '100.00',
            'promotional_price' => null,
        ]);
        $this->assertFalse($product->has_promotion);
    }

    public function test_discount_percentage_calculated_correctly(): void
    {
        $product = new Product([
            'price' => '100.00',
            'promotional_price' => '75.00',
        ]);
        $this->assertEquals(25, $product->discount_percentage);
    }

    public function test_discount_percentage_is_zero_without_promotion(): void
    {
        $product = new Product([
            'price' => '100.00',
            'promotional_price' => null,
        ]);
        $this->assertEquals(0, $product->discount_percentage);
    }
}
