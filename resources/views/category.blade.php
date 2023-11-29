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
                        Data Category
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tr>
                                <th>#</th>
                                {{-- <th>Category</th> --}}
                                <th>Category Name</th>
                                {{-- <th>Price</th> --}}
                                {{-- <th>Stock</th> --}}
                                <th>Action</th>
                            </tr>

                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    {{-- <td>Terus</td> --}}
                                    <td>{{ $category->name }}</td>

                                    {{-- <td>Rp. 100.000,00</td> --}}
                                    {{-- <td>5 pcs</td> --}}

                                    <td>
                                        <div class="d-flex" style="gap:5px;">
                                            <button onclick="edit( {{ $category->id }} )" class="btn btn-sm btn-warning">
                                                Edit
                                            </button>

                                            <form action="{{ route ('category.destroy', $category->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <button onclick="return confirm('Delete This Category?')" class="btn btn-sm btn-danger">
                                                    Delete
                                                </button>
                                            </form>

                                            {{-- <a href="{{ route('category.edit', 1) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="{{ route('category.destroy', 1) }}" class="btn btn-sm btn-danger">Hapus</a> --}}
                                        </div>
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
                        <span id="card-head">Tambah Category</span>
                    </div>

                    <div class="card-body">
                        <form id="form-category" method="POST" action="{{ route('category.store') }}">
                            @csrf
                            @method('POST')
                            <div class="form-group mb-2">
                                <label for="name">Category Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" id="name" placeholder="category name..." required>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                            </div>
                            <div class="form-group d-flex justify-content-end">
                                <input type="submit" value="Save" class="btn btn-success">
                                <button type="reset" onclick="batal()" class="btn btn-danger mx-1">Reset</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function edit(a) {
            document.getElementById("card-head").innerHTML="Edit Category";
            $.get('category/' + a + '/edit', function(data) {
                $('#name').val(data.name);
                var action = '{{ route("category.update", ":id") }}';
                action = action.replace(":id", data.id);
                $("#form-category").attr("action", action);
                $("input[name='_method']").val("PUT");
            })
        }

        function batal(){
            document.getElementById("card-head").innerHTML="Tambah Category";
            var action = '{{ route("category.store") }}';
            $("#form-category").attr("action", action);
            $('#name').val("");
        }
    </script>

@endsection
