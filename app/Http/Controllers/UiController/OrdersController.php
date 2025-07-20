<?php
// app/Http/Controllers/RoleController.php

namespace App\Http\Controllers\UiController;

use App\Http\Controllers\Controller;
use App\Services\CallApiService;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    private $call_api;

    public function __construct(CallApiService $call_api)
    {
        $this->call_api = $call_api;
    }

    public function index()
    {
        $response = $this->call_api->callApi('GET', '/api/orders?p=1');

        if (isset($response['error'])) {
            return redirect()->back()->withErrors(['error' => $response['error']]);
        }

        return view('orders.index', ['orders' => $response['data']]);
    }

    public function show($id)
    {
        $response = $this->call_api->callApi('GET', "/api/orders/{$id}");

        if (isset($response['error'])) {
            return redirect()->back()->withErrors(['error' => $response['error']]);
        }

        return view('orders.show', ['order' => $response['data']]);
    }


    public function edit($id)
    {
        $response = $this->call_api->callApi('GET', "/api/orders/{$id}");
        if (isset($response['error'])) {
            return redirect()->back()->withErrors(['error' => $response['error']]);
        }

        $users_resource = $this->call_api->callApi('GET', '/api/users?p=1');
        if (isset($users_resource['error'])) {
            return redirect()->back()->withErrors(['error' => $users_resource['error']]);
        }

        $status_resource = $this->call_api->callApi('GET', '/api/status');
        if (isset($status_resource['error'])) {
            return redirect()->back()->withErrors(['error' => $status_resource['error']]);
        }

        return view('orders.edit', [
            'order' => $response['data'],
            'users' => $users_resource['data'],
            'status' => $status_resource['data']
        ]);
    }


    public function update(Request $request, $id)
    {
        $data = $request->only(['user_id', 'status_id']);
        $response = $this->call_api->callApi('PUT', "/api/orders/{$id}", $data);

        if (isset($response['error'])) {
            return redirect()->back()->withErrors(['error' => $response['error']]);
        }

        return redirect()->route('list.orders')->with('success', 'Order updated successfully.');
    }


}
