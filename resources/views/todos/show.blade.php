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
                        Title: {{ $todo->title }}
                        <br>
                        Description: {{ $todo->body }}
                        <br>
                        Tags:
                        @foreach($todo->tags as $tag)
                            {{ $tag->name }}
                        @endforeach
                        <br>
                        Status:
                        @if($todo->is_active == 1)
                            <a class="btn btn-sm btn-success" href="">completed</a>
                        @else
                            <a class="btn btn-sm btn-danger" href="">not completed</a>
                        @endif
                        <br>
                        <a href="">Edit</a>
                        <a href="{{ route('todos.show', $todo->id) }}">View</a>
                        @if($todo->is_active == 1)
                            <a href="">Delete</a>
                        @else
                            <a href="">Submit</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
