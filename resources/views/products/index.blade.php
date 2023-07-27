@extends('layout.dashboard')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if (Session::has('message'))
                    <div class="alert alert-info">{{ Session::get('message') }}</div>
                @endif


                <table id="products-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->description }}</td>
                                <td>{{ $product->image }}</td>
                                <td>{{ $product->created_at }}</td>
                                <td>{{ $product->updated_at }}</td>


                                <td>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST">

                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">Edit</a>

                                        <a href="{{ route('assign-product', $product->id) }}"
                                            class="btn btn-success">Products</a>

                                        <button type="submit" class="btn btn-danger">Delete</button>
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#products-table').DataTable();
        });
    </script>
@endsection