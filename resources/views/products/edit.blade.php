@extends('layout.dashboard')
@section('content')
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

            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->image }}</td>
                <td>{{ $product->created_at }}</td>
                <td>{{ $product->updated_at }}</td>


                </td>
            </tr>

        </tbody>
    </table>



    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">


        <label for="name">Name </label>


        <input type="text" name="name" placeholder="name" id="name">

        <label for="image">Image </label>


        <input type="file" name="image" placeholder="image" id="image">

        <label for="description">Description</label>


        <input type="text" name="description" placeholder="description" id="description">

        <input type="submit" value="Update Product">

        @csrf
        @method('PUT')
    </form>
@endsection
