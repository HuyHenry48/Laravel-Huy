@extends('HomeWork.User.index')
@section('content')
<style>
    .box-create{
        width: 500px;
        padding: 25px 40px;
        border: 1px solid #dddddd;
        margin:0 auto;
    }
    .btn-back{
        margin-bottom: 20px;
        text-decoration: none;
    }
</style>
<a type="button" class="btn-back" href="{{ url('view-list-users')}}"><span style="font-size:20px">&#8592;</span> Back</a>
<div class="box-create"> 
    <form action="{{route('users.create')}}" method="POST" role="form" enctype="multipart/form-data">
    {{ csrf_field() }}
        <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Name</label>
        <input name="name" type="text" class="form-control" id="exampleInputEmail1">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Email</label>
        <input name="email" type="email" class="form-control" id="exampleInputPassword1" aria-describedby="emailHelp">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>


<script></script>
@endsection