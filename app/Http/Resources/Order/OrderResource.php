<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'assigned_user' => new UserResource($this->user),
            'total_amount' => $this->total_amount,
            'status' => $this->status->name,
            'items' => $this->whenLoaded('order_items', function () {
                return $this->order_items->map(function ($item) {
                    return [
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                    ];
                });
            }),
        ];
    }
}
