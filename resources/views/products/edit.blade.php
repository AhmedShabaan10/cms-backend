@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">
        <div class="row layout top-spacing">
            <div class="page-title">
                <h3>Edit Product</h3>
            </div>

            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('update.products', $product['id']) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-4">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ $product['name'] }}" required>
                        </div>

                        <div class="form-group mb-4">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control">{{ $product['description'] }}</textarea>
                        </div>

                        <div class="form-group mb-4">
                            <label for="category_id">Category</label>
                            <select name="category_id" class="form-control" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product['category']['id'] == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="stock_quantity">In Stock</label>
                                    <input type="number" name="stock_quantity" class="form-control" value="{{ $product['stock_quantity'] }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="price">Price</label>
                                    <input type="number" step="0.01" name="price" class="form-control" value="{{ $product['price'] }}" required>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
