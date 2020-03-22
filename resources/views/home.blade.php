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



                You are logged in! <br> <br>


                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                    Добавить todo
                </button>

                <!--add Modal -->
                <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="addForm" action="{{route('add')}}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Purpose</label>
                                        <input type="text" class="form-control" name="purpose" placeholder="Введите цель">
                                    </div>

                                    <div class="form-group">
                                        <label>Category</label>
                                        <input type="text" class="form-control" name="category" placeholder="Введите категорию">
                                    </div>

                                    <div class="form-group">
                                        <label>Description</label>
                                        <input type="text" class="form-control" name="description" placeholder="Введите описание">
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <br>
    {{--    search div start--}}

    <div class="row">
        <div class="panel-body">
            <input type="text" class="form-control" name="search" id="search" placeholder="Найти Todo">

        </div>
    </div>
    <br>


    {{--    search div end--}}

    <br>

    <h1 align="center">Todos</h1>
    <div class="container">
        <div class="row">
            <table class="table table-dark" >
                <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Purpose</th>
                    <th scope="col">Category</th>
                    <th scope="col">Description</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>

                <tbody id="ajax ">

                </tbody>

                <tbody id="initial_table">
                @foreach($todos as $todo)
                    <tr>
                        <td>{{$todo->id}}</td>
                        <td>{{$todo->purpose}}</td>
                        <td><a href="{{route('home.category', $todo->category)}}">{{$todo->category}}</a></td>
                        <td>{{$todo->description}}</td>
                        <td>
                            <button type="button" class="btn btn-primary editBtn">edit</button>
                            <button class="btn btn-danger deleteBtn" data-id="{{ $todo->id }}">Delete</button>
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{--edit form start--}}

    <div class="modal fade" id="editModalPopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editForm">

                    <div class="modal-body">
                        @csrf
                        @method('PUT')

                        <input type="hidden" id="id">

                        <div class="form-group">
                            <label>Purpose</label>
                            <input type="text" class="form-control" name="purpose" id="purpose" placeholder="Введите цель">
                        </div>

                        <div class="form-group">
                            <label>Category</label>
                            <input type="text" class="form-control" name="category" id="category" placeholder="Введите категорию">
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" class="form-control" name="description" id="description" placeholder="Введите описание">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>

                </form>
    {{--                                                edit form ends--}}

@endsection
