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
                                <th>Category</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Aksi</th>
                            </tr>

                            @foreach ($items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->category->name }}</td>
                                <td>{{ $item->name }}</td>
                                <td>Rp. {{ number_format($item->price, 2, '.', '.') }}</td>
                                <td>{{ $item->stock }}</td>

                                <td>
                                    <div class="d-flex" style="gap:5px;">
                                        <button onclick="edit( {{ $item->id }} )" class="btn btn-sm btn-warning">
                                            Edit
                                        </button>

                                        <form action="{{ route ('item.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button onclick="return confirm('Delete This Item?')" class="btn btn-sm btn-danger">
                                                Delete
                                            </button>
                                        </form>

                                        {{-- <a href="{{ route('item.edit', 1) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="{{ route('item.destroy', 1) }}" class="btn btn-sm btn-danger">Hapus</a> --}}                                    </div>
                                </td>
                            </tr>
                            @endforeach

                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 mb-4">
                <div class="card">
                    <div class="card-header" id="card-head">
                        Tambah Item
                    </div>
                    <div class="card-body">
                        <form method="POST" id="form-item" action="{{ route('item.store') }}">
                            @csrf
                            @method('POST')

                            <div class="form-group mb-2">
                                <label for="name">Item Category</label>
                                <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id"
                                    aria-label="category_id">
                                    <option selected disabled>Item Category...</option>

                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mb-2">
                                <label for="name">Item Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                                    placeholder="item name..." required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="price">Price</label>
                                <input type="text" class="form-control @error('price') is-invalid @enderror" name="price" id="price"
                                    placeholder="item price..." required>
                                @error('price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="stock">Stock</label>
                                <input type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" id="stock"
                                    placeholder="item stock..." required>
                                @error('stock')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group d-flex justify-content-end">
                                <input type="submit" value="Save" class="btn btn-success">
                                <button class="btn btn-danger mx-1" onclick="batal()" type="reset">Reset</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function edit(a) {
            document.getElementById("card-head").innerHTML = "Edit Item";
            $.get('item/' + a + '/edit', function(data) {
                $('#category_id').val(data.category_id);
                $('#name').val(data.name);
                $('#price').val(data.price);
                $('#stock').val(data.stock);
                var action = '{{ route("item.update", ":id") }}';
                action = action.replace(":id", data.id);
                $("#form-item").attr("action", action);
                $("input[name='_method']").val("PUT");
            })
        }
        function batal() {
            document.getElementById("card-head").innerHTML = "Tambah Item";
            var action = '{{ route("item.store") }}';
            $("#form-item").attr("action", action);
            $('#category_id').val("");
            $('#name').val("");
            $('#price').val("");
            $('#stock').val("");
        }
    </script>

@endsection
