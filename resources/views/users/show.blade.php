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

        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            $('#users-table').DataTable();
        });
    </script>
