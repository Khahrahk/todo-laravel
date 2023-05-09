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
                        <a href="{{url('todos/index')}}" class="btn btn-info">Go back</a>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-3"><h3>Title: {{ $todo->title }}</h3></div>
                            <div class="col-8">
                                <h3 style="display: inline; margin-right: 10px">Tags: </h3>
                                @foreach($todo->tags as $tag)
                                    <label class="checkbox-btn">
                                        <input type="checkbox" disabled>
                                        <span>{{ $tag->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <br>
                        <h4>Description: {{ $todo->body }}</h4>
                        <br>
                        <h4 style="display: inline; margin-right: 10px">Status: </h4>
                        @if($todo->is_active == 1)
                            <a class="btn btn-sm btn-success" href="">completed</a>
                        @else
                            <a class="btn btn-sm btn-danger" href="">not completed</a>
                        @endif
                        <br>
                        <br>
                        <h4>Image</h4>
                        <a href="{{url($todo->image)}}">
                            <img src="{{url($todo->image)}}" width="150px" height="150px"
                                 class="rounded-3"
                                 style="border: 1px solid rgba(0, 0, 0, 0.3)">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
