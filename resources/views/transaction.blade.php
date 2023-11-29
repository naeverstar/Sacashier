@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">

            @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session::get('success') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="col-lg-7 mb-4">
                <div class="card">
                    <div class="card-header">
                        Data Item
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Stock</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>

                            @foreach ($items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->category->name }}</td>
                                <td>{{ $item->stock }}</td>
                                <td>Rp. {{ number_format($item->price, 2, '.', '.') }}</td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="{{ route('transaction.add', $item->id) }}">
                                        Add to cart
                                    </a>
                                </td>
                            </tr>
                            @endforeach

                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 mb-4">
                <div class="card">
                    <div class="card-header">
                        Cart
                    </div>
                    <div class="card-body">

                        <table class="table">
                            <tr>
                                <th>#</th>
                                <th>Item</th>
                                <th class="col-md-2">Qty</th>
                                <th>Subtotal</th>
                                <th>Action</th>
                            </tr>

                            @if (session('cart'))
                                @foreach (session('cart') as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item['name'] }}</td>

                                        <td>
                                            <input class="form-control" type="number" value="{{ $item['qty'] }}">
                                        </td>

                                        <td>{{ number_format($item['subtotal'], 2, '.', '.') }}</td>

                                        <td>
                                            <a href="{{ route('transaction.delete', $item['id']) }}" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Remove this Item?')">
                                                Remove
                                            </a>
                                        </td>

                                    </tr>
                                @endforeach

                            @else
                                <tr>
                                    <td colspan="5" class="text-center">
                                        No item in cart
                                    </td>
                                </tr>
                            @endif

                            <tr>
                                <td colspan="3" class="text-end">Grand Total</td>
                                <td colspan="2"><input type="text" class="form-control"
                                        value="{{ number_format(150000, 2, '.', '.') }}" readonly></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end">Payment</td>
                                <td colspan="2"><input type="text" class="form-control"></td>
                            </tr>

                        </table>

                        <div class="form-group d-flex justify-content-end">
                            <input type="submit" value="Checkout" class="btn btn-sm btn-primary">
                            <input type="reset" value="Reset" class="btn btn-sm btn-danger mx-1">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
