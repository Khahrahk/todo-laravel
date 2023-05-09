@extends('layouts.app')

@section('content')
    <style>
        #slideSource_input_add, #slideSource_button_add, #slideSource_input_delete, #slideSource_button_delete {
            opacity: 0;
            transition: opacity 1s;
        }

        #slideSource_input_add.fade, #slideSource_button_add.fade, #slideSource_input_delete.fade, #slideSource_button_delete.fade {
            opacity: 1;
        }
    </style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="post" action="{{ route('todos.edit_submit') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" value="{{ $todo->id }}">
                            <input type="hidden" name="image" value="{{ $todo->image }}">
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" class="form-control" aria-describedby="emailHelp"
                                       value="{{$todo->title}}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="body" class="form-control" cols="5"
                                          rows="5"> {{$todo->body}} </textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Image</label>
                                <br>
                                <a href="{{url($todo->image)}}">
                                    <img src="{{url($todo->image)}}" width="150px" height="150px"
                                         class="rounded-3"
                                         style="border: 1px solid rgba(0, 0, 0, 0.3)">
                                </a>
                                <br><br>
                                <input class="form-control form-control-lg" id="formFileLg" type="file" name="image">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                @if($todo->is_active == 1)
                                    <div class="row">
                                        <div class="wrapper col-4">
                                            <input type="radio" name="is_active" value="1" id="option-1" checked>
                                            <input type="radio" name="is_active" value="0" id="option-2">
                                            <label for="option-1" class="option option-1">
                                                <span>Completed</span>
                                            </label>
                                            <label for="option-2" class="option option-2">
                                                <span>Not completed</span>
                                            </label>
                                        </div>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="wrapper col-4">
                                            <input type="radio" name="is_active" value="1" id="option-1">
                                            <input type="radio" name="is_active" value="0" id="option-2" checked>
                                            <label for="option-1" class="option option-1">
                                                <span>Completed</span>
                                            </label>
                                            <label for="option-2" class="option option-2">
                                                <span>Not completed</span>
                                            </label>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tags:</label>
                                <br>
                                <div class="row">
                                    @foreach($todo->tags as $item)
                                        <div class="col-auto">
                                            <label class="checkbox-btn m-1">
                                                <input type="checkbox" name="tag_select[]" value="{{ $item->id }}">
                                                <span>{{ $item->name }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <br>
                                <div class="row">
                                    <button type="button" id="handle_add" class="col-2 btn btn-primary"
                                            style="margin-left: 12px">Add new
                                    </button>
                                    <div id="slideSource_input_add" class="col-5">
                                        <input type="text" class="form-control" name="tag">
                                    </div>
                                    <div id="slideSource_button_add" class="col-3">
                                        <button type="submit" name="step[0]" value="Tag" class="btn btn-primary">
                                            Submit
                                        </button>
                                    </div>
                                </div>

                                <h5 class="mt-2">Or</h5>

                                <div class="row">
                                    <button type="submit" name="step[0]" value="Tag_delete" class="col-2 btn btn-primary"
                                            style="margin-left: 12px">Delete selected
                                    </button>
                                </div>

                            </div>
                            <br>
                            <button type="submit" name="step[0]" value="Form" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var slideSource_input_add = document.getElementById('slideSource_input_add');
        var slideSource_button_add = document.getElementById('slideSource_button_add');
        document.getElementById('handle_add').onclick = function () {
            slideSource_input_add.classList.toggle('fade');
            slideSource_button_add.classList.toggle('fade');
        }
    </script>
@endsection
