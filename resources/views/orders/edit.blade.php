@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">
        <div class="row layout top-spacing">
            <div class="page-title">
                <h3>ُEdit Order</h3>
            </div>

            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-8">

                    <div class="form-group mb-3">
                        <label for="order_number">Order Number</label>
                        <input type="text" class="form-control form-control-sm" value="{{ '#' . $order['id'] }}" readonly>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="total_amount">Total Amount</label>
                            <input type="text" class="form-control form-control-sm" value="{{ $order['total_amount'] }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="status">Current Status</label>
                            <input class="form-control form-control-sm" value="{{ ucfirst($order['status']) }}" readonly>
                        </div>
                    </div>

                    <div class="form-group mt-3">
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
                                            <td>{{ $item['price'] * $item['quantity'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <form action="{{ route('update.orders', $order['id']) }}" method="POST" class="mt-4">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="user_id">Assigned User</label>
                            <select name="user_id" class="form-control form-control-sm">
                                @foreach($users as $user)
                                    <option value="{{ $user['id'] }}" {{ $order['assigned_user']['id'] == $user['id'] ? 'selected' : '' }}>
                                        {{ $user['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="status_id">Order Status</label>
                            <select name="status_id" class="form-control form-control-sm">
                                @foreach($status as $stat)
                                    <option value="{{ $stat['id'] }}" {{ $order['status'] == $stat['name'] ? 'selected' : '' }}>
                                        {{ ucfirst($stat['name']) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('list.orders') }}" class="btn btn-secondary ml-2">Back to Orders</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
