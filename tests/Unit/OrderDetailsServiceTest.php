<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\Product;
use App\Services\OrderDetailsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Exceptions\StockException;

class OrderDetailsServiceTest extends TestCase
{
    // use RefreshDatabase;

    public function test_it_calculates_total_correctly()
    {
        $product1 = Product::factory()->create(['price' => 100]);
        $product2 = Product::factory()->create(['price' => 50]);

        $service = new OrderDetailsService();

        $data = [
            'order_items' => [
                ['product_id' => $product1->id, 'quantity' => 2],
                ['product_id' => $product2->id, 'quantity' => 3],
            ]
        ];

        $total = $service->calculate_total($data);

        $this->assertEquals(100*2 + 50*3, $total);
    }

    public function test_it_throws_exception_if_stock_is_insufficient()
    {
        $this->expectException(StockException::class);

        $product = Product::factory()->create([
            'price' => 100,
            'stock_quantity' => 1
        ]);

        $order = Order::factory()->create();

        $service = new OrderDetailsService();

        $data = [
            'order_items' => [
                ['product_id' => $product->id, 'quantity' => 5],
            ]
        ];

        $service->order_items($order, $data);
    }

    public function test_it_creates_order_items_and_deducts_stock()
    {
        $product = Product::factory()->create([
            'price' => 100,
            'stock_quantity' => 10
        ]);

        $order = Order::factory()->create();

        $service = new OrderDetailsService();

        $data = [
            'order_items' => [
                ['product_id' => $product->id, 'quantity' => 3],
            ]
        ];

        $service->order_items($order, $data);

        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 3,
            'price' => 100
        ]);

        $this->assertEquals(7, $product->fresh()->stock_quantity);
    }
}
