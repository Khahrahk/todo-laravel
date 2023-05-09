@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Users') }}</div>

                    <div class="card-body">

                        @if(Session::has('alert-success'))
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('alert-success') }}
                            </div>
                        @endif
                        @if(count($users) > 0)
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $item)
                                    <tr>
                                        <td>{{ $item->name}}</td>
                                        <td>
                                            @if($item->id != Auth::id())
                                                @foreach($item->related as $related)
                                                    @if($related->toId = Auth::id() && $related->fromId = $item->id)
                                                        <a class="btn btn-sm btn-light"
                                                           href="{{ route('users.view', $item->id) }}">View</a>
                                                    @endif
                                                @endforeach
                                                @foreach($item->related_one as $related)
                                                    @if($related->fromId = Auth::id() && $related->toId = $item->id)
                                                        <a class="btn btn-sm btn-light"
                                                           href="{{ route('users.delete', $item->id) }}">Delete</a>
                                                    @endif
                                                @endforeach
                                                @if(count($item->related_one) > 0)
                                                @else
                                                    <a class="btn btn-sm btn-light"
                                                       href="{{ route('users.share', $item->id) }}">Share</a>
                                                @endif
                                            @else
                                                <input type="button" class="btn btn-sm btn-danger"
                                                       value="This is you">
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
                                        {{ $users->withQueryString()->links() }}
                                    </div>
                                </div>
                                <div class="col-4"></div>
                            </div>
                        @else
                            <h5>No users created yet</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
