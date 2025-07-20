@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">
        <div class="row layout top-spacing">
            <div class="page-title">
                <h3>Show Product</h3>
            </div>

            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <div class="form-group mb-3">
                        <label for="name">Order Number</label>
                        <input type="text" id="name" class="form-control form-control-sm" value="{{ "#" . $order['id'] }}" readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label for="description">Assigned User</label>
                        <textarea class="form-control form-control-sm" rows="2" readonly>{{ $order['assigned_user']['name'] }}</textarea>
                    </div>

                    
                    <div class="row">
                        <div class="col-md-6">
                            <label for="category_id">Total Amount</label>
                            <input type="text" class="form-control form-control-sm" value="{{ $order['total_amount']}}" readonly>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="stock_quantity">Order Status</label>
                                <input class="form-control form-control-sm" value="{{ $order['status'] }}" readonly>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-4">
                                <label for="items">Order Items</label>

                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($order['items'] as $item)
                                                <tr>
                                                    <td>{{ $item['product_name'] }}</td>
                                                    <td>{{ $item['quantity'] }}</td>
                                                    <td>{{ $item['price'] }}</td>
                                                    <td>{{ $item['price']*$item['quantity'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>

                    <a href="{{ route('list.orders') }}" class="btn btn-secondary">Back to Products</a>
                </div>
            </div>
        </div>
    </div>
@endsection
