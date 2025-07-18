<?php

namespace App\Services;

use App\Exceptions\StockException;
use App\Models\Order;
use App\Models\Product;

class OrderDetailsService
{
    public function calculate_total(array $data)
    {
        $total = collect($data['order_items'])->sum(function ($item) {
            $product = Product::findOrFail($item['product_id']);
            return $product->price * $item['quantity'];
        });
        return $total;
    }

    public function order_items(Order $order, $data)
    {
        foreach ($data['order_items'] as $item) {

            $product = Product::findOrFail($item['product_id']);
            if ($product->stock_quantity < $item['quantity']) {
                throw new StockException("Not enough stock for product: {$product->name}");
            }

            $order->order_items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $product->price,
            ]);


            $product->decrement('stock_quantity', $item['quantity']);
        }
        return $order;
    }
}
