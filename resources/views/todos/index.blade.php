@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Todos') }}</div>

                    <div class="card-body">
                        @if(Session::has('alert-success'))
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('alert-success') }}
                            </div>
                        @endif
                        @if(!Auth::guest())
                            <div class="col-2">
                                <a class="btn btn-sm btn-primary" href="{{ route('todos.create') }}">Create new todo</a>
                            </div>
                            <br>
                        @endif
                        @if(count($todos) > 0)
                            <form method="get" action="{{ route('todos.search')}}">
                                <div class="row">
                                    <div class="col-11">
                                        <div class="row">
                                            <div class="col-9"><h3>Todo list</h3></div>
                                            <div class="mb-2 col-3">
                                                <input type="text" name="search" class="form-control"
                                                       aria-describedby="emailHelp">
                                            </div>
                                        </div>
                                        <div class="row justify-content-end">
                                            <div class="col-auto mt-1">
                                                <h4 style="display: inline;">Tags:</h4>
                                            </div>
                                            @if(count($tags) > 0)
                                                @foreach($tags as $item)
                                                    @if($item != null)
                                                        <div class="col-auto">
                                                            <label class="checkbox-btn">
                                                                <input type="checkbox" name="tag[]" value="{{ $item }}">
                                                                <span>{{ $item }}</span>
                                                            </label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                                <div class="col-auto"></div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <button type="submit" class="btn btn-primary" style="height: 80px">Search
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Image</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Tags</th>
                                    <th scope="col">Active</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($todos as $item)
                                    <tr>
                                        <td>
                                            <a href="{{url($item->image)}}">
                                                <img src="{{url($item->image)}}" width="150px" height="150px"
                                                     class="rounded-3"
                                                     style="border: 1px solid rgba(0, 0, 0, 0.3)">
                                            </a>
                                        </td>
                                        <td>{{ $item->title }}</td>
                                        <td>{{ $item->body }}</td>
                                        <td>
                                            @foreach($item->tags as $tag)
                                                <label class="checkbox-btn">
                                                    <input type="checkbox" disabled>
                                                    <span>{{ $tag->name }}</span>
                                                </label>
                                            @endforeach
                                        </td>
                                        <td>
                                            @if($item->is_active == 1)
                                                <a class="btn btn-sm btn-success" href="">completed</a>
                                            @else
                                                <a class="btn btn-sm btn-danger" href="">not completed</a>
                                            @endif
                                        </td>
                                        <td>
                                            <a class="btn btn-sm btn-light" href="{{ route('todos.edit', $item->id) }}">Edit</a>
                                            <a class="btn btn-sm btn-light" href="{{ route('todos.show', $item->id) }}">View</a>
                                            @if($item->is_active == 1)
                                                <a class="btn btn-sm btn-light" href="{{ route('todos.delete', $item->id) }}">Delete</a>
                                            @else
                                                <a class="btn btn-sm btn-light" href="{{ route('todos.submit', $item->id) }}">Submit</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-4"></div>
                                <div class="col-4">
                                    <div class="d-flex justify-content-center">
                                        {{ $todos->withQueryString()->links() }}
                                    </div>
                                </div>
                                <div class="col-4"></div>
                            </div>
                        @else
                            <h5>No todos created yet</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
