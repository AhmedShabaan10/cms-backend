<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        if ($unauthorized = $this->authorize('product-list')) {
            return $unauthorized;
        }

        $products = Product::with('category')->paginate(30);
        return ProductResource::collection($products);
    }

    
    public function show($id)
    {
        if ($unauthorized = $this->authorize('product-view')) {
            return $unauthorized;
        }
        $product = Product::with('category')->findOrFail($id);

        return new ProductResource($product);
    }


    public function store(CreateProductRequest $request)
    {
        if ($unauthorized = $this->authorize('product-create')) {
            return $unauthorized;
        }

        $data = $request->all();

        $product = Product::create($data);

        return response()->json([
            'message' => 'Product created successfully',
            'product' => new ProductResource($product)
        ]);
    }


    public function update(UpdateProductRequest $request, $id)
    {
        if ($unauthorized = $this->authorize('product-update')) {
            return $unauthorized;
        }

        $data = $request->all();
        $product = Product::findOrFail($id);

        $product->update($data);

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => new ProductResource($product)
        ]);
    }


    public function destroy($id)
    {
        if ($unauthorized = $this->authorize('product-delete')) {
            return $unauthorized;
        }

        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully'
        ]);
    }
}
