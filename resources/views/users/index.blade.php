@extends('layout.dashboard')
@section('content')
    <!DOCTYPE html>
    <html lang="en">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Users</h1>

                @if (Session::has('message'))
                    <div class="alert alert-info">{{ Session::get('message') }}</div>
                @endif
                <a href="{{ route('users.create') }}" class="btn btn-primary">Create User</a>

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
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->first_name }}</td>
                                <td>{{ $user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone_number }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>{{ $user->updated_at }}</td>

                                <td>
                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">Edit</a>
                                    <a href="{{ route('users.destroy', $user) }}" class="btn btn-danger">Delete</a>
                                    <a href="{{ route('users.products', $user) }}" class="btn btn-success">Products</a>
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
            $('#users-table').DataTable();
        });
    </script>


    </html>
@endsection
