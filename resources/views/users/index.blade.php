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
                                                @if($item->sharedtodo != false)
                                                    @foreach($item->sharedtodo as $todo)
                                                        @if($todo->fromId == Auth::id() && $todo->toId == $item->id)
                                                            <input type="button" class="btn btn-sm btn-danger"
                                                                   value="delete">
                                                        @endif
                                                        @if($todo->fromId == $item->id && $todo->toId == Auth::id())
                                                            <a href="{{ route('users.view', $item->id) }}"><input type="button" class="btn btn-sm btn-danger" value="View"></a>
                                                        @endif
                                                        @if(($todo->fromId != Auth::id() && $todo->toId != $item->id && $todo->toId != Auth::id()))
                                                                <input type="button" class="btn btn-sm btn-danger"
                                                                       value="Share">
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @else
                                                <input type="button" class="btn btn-sm btn-danger" value="this is you">
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
