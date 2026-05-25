<?php

namespace Tests\Unit\Models;

use App\Models\Order;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function test_generates_code_with_fl_prefix(): void
    {
        $code = Order::generateCode();
        $this->assertStringStartsWith('FL', $code);
    }

    public function test_generates_unique_codes(): void
    {
        $this->assertNotEquals(Order::generateCode(), Order::generateCode());
    }

    public function test_status_labels_cover_all_statuses(): void
    {
        $labels = Order::statusLabels();
        $this->assertArrayHasKey(Order::STATUS_PENDING, $labels);
        $this->assertArrayHasKey(Order::STATUS_PROCESSING, $labels);
        $this->assertArrayHasKey(Order::STATUS_SHIPPED, $labels);
        $this->assertArrayHasKey(Order::STATUS_DELIVERED, $labels);
        $this->assertArrayHasKey(Order::STATUS_CANCELLED, $labels);
    }

    public function test_payment_labels_cover_all_methods(): void
    {
        $labels = Order::paymentLabels();
        $this->assertArrayHasKey(Order::PAYMENT_CREDIT_CARD, $labels);
        $this->assertArrayHasKey(Order::PAYMENT_PIX, $labels);
        $this->assertArrayHasKey(Order::PAYMENT_BOLETO, $labels);
    }

    public function test_status_label_accessor_pending(): void
    {
        $order = new Order(['status' => Order::STATUS_PENDING]);
        $this->assertEquals('Pendente', $order->status_label);
    }

    public function test_status_label_accessor_delivered(): void
    {
        $order = new Order(['status' => Order::STATUS_DELIVERED]);
        $this->assertEquals('Entregue', $order->status_label);
    }

    public function test_status_label_accessor_cancelled(): void
    {
        $order = new Order(['status' => Order::STATUS_CANCELLED]);
        $this->assertEquals('Cancelado', $order->status_label);
    }

    public function test_status_color_pending_is_warning(): void
    {
        $order = new Order(['status' => Order::STATUS_PENDING]);
        $this->assertEquals('warning', $order->status_color);
    }

    public function test_status_color_delivered_is_success(): void
    {
        $order = new Order(['status' => Order::STATUS_DELIVERED]);
        $this->assertEquals('success', $order->status_color);
    }

    public function test_status_color_cancelled_is_danger(): void
    {
        $order = new Order(['status' => Order::STATUS_CANCELLED]);
        $this->assertEquals('danger', $order->status_color);
    }

    public function test_payment_label_pix(): void
    {
        $order = new Order(['payment_method' => Order::PAYMENT_PIX]);
        $this->assertEquals('PIX', $order->payment_label);
    }

    public function test_payment_label_credit_card(): void
    {
        $order = new Order(['payment_method' => Order::PAYMENT_CREDIT_CARD]);
        $this->assertEquals('Cartão de Crédito', $order->payment_label);
    }
}
