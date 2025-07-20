<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductController extends Controller
{

    public function index()
    {
        if ($unauthorized = $this->authorize('product-list')) {
            return $unauthorized;
        }

        if (request()->boolean('p')) {
            $products = Product::with('category')->get();
            return ProductResource::collection($products);
        }

        $products = Product::with('category')->paginate(30);
        return ProductResource::collection($products);
    }


    public function show($id)
    {
        if ($unauthorized = $this->authorize('product-view')) {
            return $unauthorized;
        }
        try {

            $product = Product::with('category')->findOrFail($id);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Product not found.'
            ], 404);
        }
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
        try {

            $product = Product::findOrFail($id);
            $product->update($data);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Product not found.'
            ], 404);
        }

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

        try {
            $product = Product::findOrFail($id);
            if ($product->orders()->count() > 0) {
                return response()->json([
                    'message' => 'Cannot delete product with associated orders.'
                ], 403);
            }
            $product->delete();
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Product not found.'
            ], 404);
        }

        return response()->json([
            'message' => 'Product deleted successfully'
        ]);
    }
}
