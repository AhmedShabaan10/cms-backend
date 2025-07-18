<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    // use RefreshDatabase;

    public function test_admin_can_create_order_and_deduct_stock()
    {
        $admin = User::factory()->create();
        $admin->roles()->sync([User::ADMIN_User]);

        $product = Product::factory()->create([
            'stock_quantity' => 50,
        ]);


        $payload = [
            'user_id' => $admin->id,
            'status_id' => 1,
            'order_items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 3,
                ]
            ]
        ];

        $response = $this->actingAs($admin, 'sanctum')->postJson('/api/orders', $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('orders', [
            'user_id' => $admin->id,
            'status_id' => 1,
        ]);

        $this->assertDatabaseHas('order_items', [
            'product_id' => $product->id,
            'quantity' => 3,
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock_quantity' => 47,
        ]);
    }

    public function test_admin_can_view_orders()
    {
        $admin = User::factory()->create();
        $admin->roles()->sync([User::ADMIN_User]);


        $response = $this->actingAs($admin, 'sanctum')->getJson('/api/orders');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'assigned_user',
                    'status',
                    'total_amount',
                ],
            ],
        ]);
    }

    public function test_admin_can_view_single_order()
    {
        $admin = User::factory()->create();
        $admin->roles()->sync([User::ADMIN_User]);

        $order = Order::factory()->create();

        $response = $this->actingAs($admin, 'sanctum')->getJson("/api/orders/{$order->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'assigned_user',
                'status',
                'total_amount',
                'items' => [
                    '*' => [
                        'product_id',
                        'quantity',
                        'price'
                    ]
                ]
            ],
        ]);

    }

    public function test_view_non_existing_order_returns_404()
    {
        $admin = User::factory()->create();
        $admin->roles()->sync([User::ADMIN_User]);

        $response = $this->actingAs($admin, 'sanctum')->getJson('/api/orders/9999');

        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'Order not found.',
        ]);
    }

}
