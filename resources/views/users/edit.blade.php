@extends('layout.dashboard')
@section('content')
    <table id="users-table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>

            <tr>
                <td>{{ $user->first_name }}</td>
                <td>{{ $user->last_name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone_number }}</td>
                <td>{{ $user->created_at }}</td>
                <td>{{ $user->updated_at }}</td>


            </tr>

        </tbody>
    </table>

    <form action="{{ route('users.update',$product->id) }}" method="POST">
      

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
        <input type="submit" value="Update User">

        @method('PUT')
        @csrf
    </form>
@endsection
