@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if(Session::has('alert-success'))
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('alert-success') }}
                            </div>
                        @endif
                        @if(count($todos) > 0)
                            <form method="get" action="{{ route('todos.search')}}">
                                @csrf
                                {{--                                <div class="row">--}}
                                {{--                                    <div class="col-8"><h3>Todo list</h3>--}}
                                {{--                                        <div class="row">--}}
                                {{--                                            <div class="row justify-content-end">--}}
                                {{--                                                <div class="col-auto mt-1">--}}
                                {{--                                                    <h4 style="display: inline;">Tags:</h4>--}}
                                {{--                                                </div>--}}
                                {{--                                                @if(count($tags) > 0)--}}
                                {{--                                                    @foreach($tags as $item)--}}
                                {{--                                                        <div class="col-auto">--}}
                                {{--                                                            <label class="checkbox-btn">--}}
                                {{--                                                                <input type="checkbox" name="tag" value="{{ $item }}">--}}
                                {{--                                                                <span>{{ $item }}</span>--}}
                                {{--                                                            </label>--}}
                                {{--                                                        </div>--}}
                                {{--                                                    @endforeach--}}
                                {{--                                                @endif--}}
                                {{--                                            </div>--}}
                                {{----}}
                                {{--                                        </div>--}}
                                {{--                                    </div>--}}
                                {{--                                    <div class="col-1">--}}
                                {{--                                        <button type="submit" class="btn btn-primary" style="height: 80px">Search--}}
                                {{--                                        </button>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
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
                                                    <div class="col-auto">
                                                        <label class="checkbox-btn">
                                                            <input type="checkbox" name="tag" value="{{ $item }}">
                                                            <span>{{ $item }}</span>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <button type="submit" class="btn btn-primary" style="height: 80px">Search
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <br>
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
                                            <a href="{{url('k1.jpg')}}">
                                                <img src="{{url($item->image)}}" width="150px" height="150px"
                                                     style="border: 1px solid rgba(0, 0, 0, 0.3)">
                                            </a>
                                        </td>
                                        <td>{{ $item->title }}</td>
                                        <td>{{ $item->body }}</td>
                                        <td>
                                            @foreach($item->tags as $oof)
                                                {{ $oof->name }}
                                                <br>
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
                                            <a class="btn btn-sm btn-light" href="">Edit</a>
                                            <a class="btn btn-sm btn-light" href="{{ route('todos.show', $item->id) }}">View</a>
                                            <a class="btn btn-sm btn-light" href="">Submit</a>
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
