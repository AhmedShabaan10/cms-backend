<?php
// app/Http/Controllers/RoleController.php

namespace App\Http\Controllers\UiController;

use App\Http\Controllers\Controller;
use App\Services\CallApiService;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    private $call_api;

    public function __construct(CallApiService $call_api)
    {
        $this->call_api = $call_api;
    }

    public function index()
    {
        $response = $this->call_api->callApi('GET', '/api/products?p=1');

        if (isset($response['error'])) {
            return redirect()->back()->withErrors(['error' => $response['error']]);
        }

        return view('products.index', ['products' => $response['data']]);
    }

    public function create()
    {
        $categories_response = $this->call_api->callApi('GET', '/api/categories');
        if (isset($categories_response['error'])) {
            return redirect()->back()->withErrors(['error' => $categories_response['error']]);
        }

        return view('products.create', ['categories' => $categories_response['data']]);
    }


    public function store(Request $request)
    {
        $data = $request->only(['name', 'description', 'category_id', 'stock_quantity', 'price']);

        $response = $this->call_api->callApi('POST', '/api/products', $data);

        if (isset($response['error'])) {
            return redirect()->back()->withErrors(['error' => $response['error']]);
        }

        return redirect()->route('list.products', ['message' => $response['message'] ?? 'Product created successfully.']);
    }

    public function edit($id)
    {
        $response = $this->call_api->callApi('GET', "/api/products/{$id}");

        if (isset($response['error'])) {
            return redirect()->back()->withErrors(['error' => $response['error']]);
        }

        $categories_response = $this->call_api->callApi('GET', '/api/categories');
        if (isset($categories_response['error'])) {
            return redirect()->back()->withErrors(['error' => $categories_response['error']]);
        }

        return view('products.edit', ['product' => $response['data'], 'categories' => $categories_response['data']]);
    }


    public function update(Request $request, $id)
    {
        $data = $request->only(['name', 'description', 'category_id', 'stock_quantity', 'price']);

        $response = $this->call_api->callApi('PUT', "/api/products/{$id}", $data);

        if (isset($response['error'])) {
            return redirect()->back()->withErrors(['error' => $response['error']]);
        }

        return redirect()->route('list.products');
    }


    public function destroy($id)
    {
        $response = $this->call_api->callApi('DELETE', "/api/products/{$id}");
        if (isset($response['error'])) {
            return redirect()->back()->withErrors(['error' => $response['error']]);
        }

        return redirect()->route('list.products');
    }
}
