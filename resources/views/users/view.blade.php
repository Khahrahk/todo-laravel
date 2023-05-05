@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">

                        @if(Session::has('alert-success'))
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('alert-success') }}
                            </div>
                        @endif
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Image</th>
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Tags</th>
                                <th scope="col">Active</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($users->id != Auth::id())
                                @if($users->sharedtodo != false)
                                    @foreach($users->sharedtodo as $todo)
                                        @if($todo->fromId == $users->id && $todo->toId == Auth::id())
                                            @foreach($users->todos as $item)
                                                <tr>
                                                    <td>
                                                        <a href="{{url('k1.jpg')}}">
                                                            <img src="{{url($item->image)}}" width="150px"
                                                                 height="150px"
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
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            @else
                                <input type="button" class="btn btn-sm btn-danger" value="this is you">
                            @endif
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-4"></div>
                            <div class="col-4">
                                <div class="d-flex justify-content-center">
                                </div>
                            </div>
                            <div class="col-4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
