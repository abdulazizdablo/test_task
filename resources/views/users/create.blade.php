@extends('layout.dashboard')

@section('content')

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <label for="first_name">First Name </label>


        <input type="text" name="first_name" placeholder="first_name" id="first_name">

        <label for="last_name">Last Name </label>


        <input type="text" name="last_name" placeholder="last_name" id="last_name">

        <label for="email">Email </label>


        <input type="text" name="email" placeholder="email" id="email">
        <label for="password">Password </label>


        <input type="password" name="password" placeholder="password" id="password">


        <label for="phone_number">Phone Number </label>



        <input type="password" name="phone_number" placeholder="phone_number" id="phone_number">
        <input type="submit" value="Create User">
    </form>
    @endsection
