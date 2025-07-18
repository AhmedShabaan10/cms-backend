<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\CreateOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order;
use App\Services\OrderDetailsService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected $details;
    public function __construct(OrderDetailsService $details)
    {
        $this->details = $details;
    }
    
    public function index()
    {
        if ($unauthorized = $this->authorize('orders-list')) {
            return $unauthorized;
        }

        $orders = Order::with('user')->paginate(30);
        return OrderResource::collection($orders);
    }

    public function show($id)
    {
        if ($unauthorized = $this->authorize('orders-view')) {
            return $unauthorized;
        }

        try {
            $order = Order::with('user', 'order_items')->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Order not found.'
            ], 404);
        }
        return new OrderResource($order);
    }

    public function store(CreateOrderRequest $request)
    {
        if ($unauthorized = $this->authorize('orders-create')) {
            return $unauthorized;
        }

        $data = $request->all();
        $order = DB::transaction(function () use ($data) {

            $total = $this->details->calculate_total($data);

            $order = Order::create([
                'user_id' => $data['user_id'],
                'status_id' => $data['status_id'],
                'total_amount' => $total,
            ]);

            $this->details->order_items($order, $data);

            return $order;
        });

        return response()->json([
            'message' => 'Order created successfully',
            'order' => new OrderResource($order->load('order_items'))
        ]);
    }

    public function update(UpdateOrderRequest $request, $id)
    {
        if ($unauthorized = $this->authorize('orders-update')) {
            return $unauthorized;
        }

        $data = $request->all();

        try {
            $order = Order::findOrFail($id);
            $order->update([
                'user_id' => $data['user_id'],
                'status_id' => $data['status_id'],
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Order not found.'
            ], 404);
        }
        return response()->json([
            'message' => 'Order updated successfully',
            'order' => new OrderResource($order->load('order_items'))
        ]);
    }
}
