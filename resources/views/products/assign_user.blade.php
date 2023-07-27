@extends('layout.dashboard')
@section('content')


  


        <form method="POST" action="{{ route('products.assign-user', $user) }}">


            @csrf
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
                    @foreach ($user as $item)
                        <tr>
                            <td>{{ $item->first_name }}</td>
                            <td>{{ $item->last_name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->phone_number }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>{{ $item->updated_at }}</td>
                    @endforeach
                </tbody>
            </table>


            <h1> Assign product</h1>

            <label for="name"> Product Name </label>
            <input type="text" name="name" placeholder="name" id="name">
        </form>

  

    <script>
        $(document).ready(function() {
            $('#users-table').DataTable();
        });
    </script>

    
