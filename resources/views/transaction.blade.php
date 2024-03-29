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

            @if (Session::has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ session::get('error') }}</strong>
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
                                        <a class="btn btn-sm btn-primary" href="{{ route('transaction.add', $item->id) }}">
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
                                @php $total = 0; @endphp
                                @foreach (session('cart') as $item)
                                    @php $total += $item['subtotal']; @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item['name'] }}</td>

                                        <form action="{{ route('cart.update') }}" method="POST">
                                            @csrf

                                            <input type="hidden" name="id" value="{{ $item['id'] }}">
                                            <td>
                                                <input onchange="ubah{{ $loop->iteration }}()" class="form-control"
                                                    type="number" name="qty" id="qty"
                                                    value="{{ $item['qty'] }}">
                                            </td>
                                            <td>{{ number_format($item['subtotal'], 2, '.', '.') }}</td>

                                            <td>
                                                <a id="delete{{ $loop->iteration }}"
                                                    href="{{ route('transaction.delete', $item['id']) }}"
                                                    class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Remove this Item?')">
                                                    Remove
                                                </a>
                                                <input id="update{{ $loop->iteration }}" style="display: none"
                                                    type="submit" class="btn btn-sm btn-primary" value="Update">
                                            </td>

                                            <script>
                                                function ubah{{ $loop->iteration }}() {
                                                    $("#delete{{ $loop->iteration }}").hide();
                                                    $("#update{{ $loop->iteration }}").show();
                                                }
                                            </script>

                                        </form>
                                    </tr>
                                @endforeach

                            <form action="{{ route('transaction.store') }}" method="post">
                                @csrf

                                    <tr>
                                        <td colspan="3" class="text-end">Grand Total</td>
                                        <td colspan="2">
                                            <input name="total" id="total" type="number" class="form-control" value="{{ $total }}" readonly>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="3" class="text-end">Pay Total</td>
                                        <td colspan="2">
                                            <input type="number" class="form-control" name="pay_total" id="pay_total" onkeyup="hitung()" min="{{ $total }}" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-end">Change</td>
                                        <td colspan="2">
                                            <input type="number" class="form-control" id="change" name="change" readonly>
                                        </td>
                                    </tr>

                                    <script>
                                        // var total = {{ $total }}
                                        // $('#total').val(total.toLocaleString())

                                        function hitung() {
                                            // alert('lah');
                                            var bayar = $('#pay_total').val();
                                            var total = $('#total').val();
                                            var change = bayar - total;
                                            // var change = (bayar - total).toLocaleString();
                                            $('#change').val(change)
                                        };
                                    </script>
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            No item in cart
                                        </td>
                                    </tr>
                            @endif

                        </table>

                            <div class="form-group d-flex justify-content-end">
                                <input type="submit" value="Checkout" class="btn btn-sm btn-primary">
                                <input type="reset" value="Reset" class="btn btn-sm btn-danger mx-1">
                            </div>

                            </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
