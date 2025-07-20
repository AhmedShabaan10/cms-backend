<?php
// app/Http/Controllers/RoleController.php

namespace App\Http\Controllers\UiController;

use App\Http\Controllers\Controller;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index()
    {
        $productsRequest = Request::create('/api/orders?p=1', 'GET', [], [], [], [
            'HTTP_Authorization' => 'Bearer ' . session('api_token'),
            'HTTP_ACCEPT' => 'application/json'
        ]);
        $response = app()->handle($productsRequest);

        if ($response->getStatusCode() === 200) {
            $productsData = json_decode($response->getContent(), true);
            $orders = $productsData['data'] ?? $productsData;
        }

        if ($response->getStatusCode() !== 200) {
            $responseData = json_decode($response->getContent(), true);
            $errorMessage = $responseData['message'] ?? 'Failed to get roles.';
            return redirect()->back()->withErrors(['error' => $errorMessage]);
        }

        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $apiRequest = Request::create("/api/orders/{$id}", 'GET', [], [], [], [
            'HTTP_Authorization' => 'Bearer ' . session('api_token'),
            'HTTP_ACCEPT' => 'application/json'
        ]);

        $response = app()->handle($apiRequest);

        if ($response->getStatusCode() === 200) {
            $data = json_decode($response->getContent(), true);
            $order = $data['data'] ?? $data;
        }

        if ($response->getStatusCode() !== 200) {
            $responseData = json_decode($response->getContent(), true);
            $errorMessage = $responseData['message'] ?? 'Failed to get order.';
            return redirect()->back()->withErrors(['error' => $errorMessage]);
        }

        return view('orders.show', compact('order'));
    }

    public function edit($id)
    {
        if (session('api_token')) {
            $apiRequest = Request::create("/api/orders/{$id}", 'GET', [], [], [], [
                'HTTP_Authorization' => 'Bearer ' . session('api_token'),
                'HTTP_ACCEPT' => 'application/json'
                ,
            ]);

            $response = app()->handle($apiRequest);

            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getContent(), true);
                $order = $data['data'] ?? $data;
            }

            if ($response->getStatusCode() !== 200) {
                $responseData = json_decode($response->getContent(), true);
                $errorMessage = $responseData['message'] ?? 'Failed to get order.';
                return redirect()->back()->withErrors(['error' => $errorMessage]);
            }
            $users = User::all();
            $status = Status::all();

        }
        return view('orders.edit', compact('order', 'users' , 'status'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->only([
            'user_id',
            'status_id',       
        ]);

        $apiRequest = Request::create(
            "/api/orders/{$id}",
            'PUT',
            $data,
            [],
            [],
            [
                'HTTP_Authorization' => 'Bearer ' . session('api_token'),
                'HTTP_ACCEPT' => 'application/json'
            ]
        );

        $response = app()->handle($apiRequest);
        // dd($response);

        if ($response->getStatusCode() !== 200) {
            $responseData = json_decode($response->getContent(), true);
            $errorMessage = $responseData['message'] ?? 'Failed to update role.';
            return redirect()->back()->withErrors(['error' => $errorMessage]);
        }
        return redirect()->route('list.orders')->with('success', 'Order updated successfully.');

    }

}
