@extends('layouts.app')

@section('content')
    <div class="row">

        <div class="card">

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="card-body">
                    Admin page <br> <br>
                </div>
            </div>
        </div>
    </div>

    <h1 align="center">Users</h1>
    <div class="container">
        <div class="row">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Action</th>
                    <th scope="col">AddRole</th>
                </tr>
                </thead>

                <tbody id="initial_table">

                @foreach($users as $user)
                    <form method="get" action="{{route('storeUser', $user->id)}}">
@csrf
                        @method('PUT')
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td><a class="btn btn-danger" href="{{route('deleteUser' , $user->id)}}">Удалить юзера</a></td>
                        <td><select name="roles[]">
                                @foreach($roles as $role)

                                        <option value="{{$role->id}}">{{$role->name}}</option>

                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </td>


                    </tr>
                    </form>
                @endforeach

                </tbody>
            </table>


@endsection


