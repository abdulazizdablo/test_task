@extends('layout.dashboard')
@section('content')

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="name">Name </label>


        <input type="text" name="name" placeholder="name" id="name">

        <label for="image">Image </label>


        <input type="file" name="image" placeholder="image" id="image">

        <label for="description">Description</label>


        <input type="text" name="description" placeholder="description" id="description">

        <input type="submit" value="Create Product">
    </form>
    @endsection
