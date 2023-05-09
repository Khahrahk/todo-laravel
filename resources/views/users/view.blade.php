@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
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
                            @foreach($users->todos as $item)
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
                                </tr>
                            @endforeach
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
