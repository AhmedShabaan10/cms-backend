<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    // use RefreshDatabase;

    public function test_admin_can_create_product()
    {
        $admin = User::factory()->create();

        $admin->roles()->sync([User::ADMIN_User]);

        $response = $this->actingAs($admin, 'sanctum')->postJson('/api/products', [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 99.99,
            'category_id' => 1,
            'stock_quantity' => 50,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'price' => 99.99,
        ]);
    }

    public function test_admin_can_view_a_product()
    {
        $admin = User::factory()->create();
        $admin->roles()->sync([User::ADMIN_User]);

        $product = Product::factory()->create();

        $response = $this->actingAs($admin, 'sanctum')->getJson("/api/products/{$product->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                    'name',
                    'description',
                    'price',
                    'stock_quantity'
                ]
            ]
        );
    }

    public function test_not_found_product_returns_404()
    {
        $admin = User::factory()->create();
        $admin->roles()->sync([User::ADMIN_User]);

        $response = $this->actingAs($admin, 'sanctum')->getJson('/api/products/9999');

        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'Product not found.',
        ]);
    }

    public function test_admin_can_update_product()
    {
        $admin = User::factory()->create();
        $admin->roles()->sync([User::ADMIN_User]);

        $product = Product::factory()->create();

        $response = $this->actingAs($admin, 'sanctum')->putJson("/api/products/{$product->id}", [
            'name' => 'New Name',
            'description' => 'Updated Description',
            'price' => 150.00,
            'category_id' => 2,
            'stock_quantity' => 80,
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'name' => 'New Name',
            'price' => 150.00,
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'New Name',
            'price' => 150.00,
        ]);
    }

    public function test_update_non_existing_product_returns_404()
    {
        $admin = User::factory()->create();
        $admin->roles()->sync([User::ADMIN_User]);

        $response = $this->actingAs($admin, 'sanctum')->putJson('/api/products/9999', [
            'name' => 'Anything',
            'price' => 123,
            'category_id' => 1,
            'stock_quantity' => 10,
        ]);

        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'Product not found.',
        ]);
    }


    public function test_admin_can_delete_product()
    {
        $admin = User::factory()->create();
        $admin->roles()->sync([User::ADMIN_User]);

        $product = Product::factory()->create();

        $response = $this->actingAs($admin, 'sanctum')->deleteJson("/api/products/{$product->id}");

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Product deleted successfully',
        ]);

        $this->assertDatabaseMissing('products', [
            'id' => $product,
        ]);
    }

    public function test_delete_non_existing_product_returns_404()
    {
        $admin = User::factory()->create();
        $admin->roles()->sync([User::ADMIN_User]);

        $response = $this->actingAs($admin, 'sanctum')->deleteJson('/api/products/9999');

        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'Product not found.',
        ]);
    }


    public function test_admin_can_view_product_list()
    {
        $admin = User::factory()->create();
        $admin->roles()->sync([User::ADMIN_User]);


        $response = $this->actingAs($admin, 'sanctum')->getJson('/api/products');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'description',
                    'price',
                    'category',
                    'stock_quantity'
                ]
            ]
        ]);
    }
}

