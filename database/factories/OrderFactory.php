<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'total_amount' => 0,
            'status_id' => $this->faker->randomElement([1, 2, 3]),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Order $order) {
            $items = OrderItem::factory()
                ->count(rand(1, 4))
                ->create([
                    'order_id' => $order->id,
                    'product_id' => Product::inRandomOrder()->first()->id,
                ]);

            $total = $items->sum(fn($item) => $item->price * $item->quantity);
            $order->update(['total_amount' => $total]);
        });
    }
}