@extends('HomeWork.User.index')
@section('content')
    <style>
        .box-header-table{
            display: flex;
            justify-content: space-between;
        }

    </style>
        <div class="box-header-table">
            <h4 style="margin-bottom:30px">List Users</h4>
            <a href="{{ url('view-create-user')}}" style="max-height:38px; width:90px" type="button" class="btn btn-primary">+ Add</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Created at</th>
                    <th scope="col">Updated at</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <th scope="row">{{ $user['id'] }}</th>
                        <td>{{ $user['name'] }}</td>
                        <td>{{ $user['email'] }}</td>
                        <td>{{ $user['created_at'] }}</td>
                        <td>{{ $user['updated_at'] }}</td>
                        <td><a href="{{route('users.viewEdit', $user['id'])}}" type="button" class="btn btn-warning">Edit</a></td>
                        <td><a href="{{route('users.delete', $user['id'])}}" type="button" class="btn btn-danger" >Delete</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
@endsection
