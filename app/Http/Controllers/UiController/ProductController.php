<?php
// app/Http/Controllers/RoleController.php

namespace App\Http\Controllers\UiController;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\Permission;

class ProductController extends Controller
{
    public function index()
    {
        $productsRequest = Request::create('/api/products?p=1', 'GET', [], [], [], [
            'HTTP_Authorization' => 'Bearer ' . session('api_token'),
            'HTTP_ACCEPT' => 'application/json'
        ]);
        $response = app()->handle($productsRequest);

        if ($response->getStatusCode() === 200) {
            $productsData = json_decode($response->getContent(), true);
            $products = $productsData['data'] ?? $productsData;
        }

        if ($response->getStatusCode() !== 200) {
            $responseData = json_decode($response->getContent(), true);
            $errorMessage = $responseData['message'] ?? 'Failed to get roles.';
            return redirect()->back()->withErrors(['error' => $errorMessage]);
        }

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->only(['name', 'description', 'category_id', 'stock_quantity', 'price']);

        if (session('api_token')) {
            $apiRequest = Request::create(
                "/api/products",
                'POST',
                $data,
                [],
                [],
                [
                    'HTTP_Authorization' => 'Bearer ' . session('api_token'),
                    'HTTP_ACCEPT' => 'application/json',
                ]
            );
            $response = app()->handle($apiRequest);

            if ($response->getStatusCode() !== 200) {
                $responseData = json_decode($response->getContent(), true);
                $errorMessage = $responseData['message'] ?? 'Failed to create product.';
                return redirect()->back()->withErrors(['error' => $errorMessage]);
            }
        }

        return redirect()->route('list.products');
    }

    public function edit($id)
    {
        if (session('api_token')) {
            $apiRequest = Request::create("/api/products/{$id}", 'GET', [], [], [], [
                'HTTP_Authorization' => 'Bearer ' . session('api_token'),
                'HTTP_ACCEPT' => 'application/json'
                ,
            ]);

            $response = app()->handle($apiRequest);

            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getContent(), true);
                $product = $data['data'] ?? $data;
            }

            if ($response->getStatusCode() !== 200) {
                $responseData = json_decode($response->getContent(), true);
                $errorMessage = $responseData['message'] ?? 'Failed to get product.';
                return redirect()->back()->withErrors(['error' => $errorMessage]);
            }
            $categories = Category::all();

        }
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->only(['name', 'description', 'category_id', 'stock_quantity', 'price']);

        $apiRequest = Request::create(
            "/api/products/{$id}",
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

        if ($response->getStatusCode() !== 200) {
            $responseData = json_decode($response->getContent(), true);
            $errorMessage = $responseData['message'] ?? 'Failed to update role.';
            return redirect()->back()->withErrors(['error' => $errorMessage]);
        }
        return redirect()->route('list.products');

    }


    public function destroy($id)
    {
        $apiRequest = Request::create(
            "/api/products/{$id}",
            'DELETE',
            [],
            [],
            [],
            [
                'HTTP_Authorization' => 'Bearer ' . session('api_token'),
                'HTTP_ACCEPT' => 'application/json'
            ]
        );

        $response = app()->handle($apiRequest);

        if ($response->getStatusCode() !== 200) {
            $responseData = json_decode($response->getContent(), true);
            $errorMessage = $responseData['message'] ?? 'Failed to delete role.';
            return redirect()->back()->withErrors(['error' => $errorMessage]);
        }
        return redirect()->route('list.products');

    }
}
