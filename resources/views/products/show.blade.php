@extends('layout.dashboard')
@section('content')
    <table id="products-table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Image</th>
                <th>Description</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>

            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->image }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->created_at }}</td>
                <td>{{ $product->updated_at }}</td>

        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            $('#products-table').DataTable();
        });
    </script>
@endsection