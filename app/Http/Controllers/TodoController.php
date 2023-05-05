<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\TodoRequest;
use App\Models\SharedTodo;
use App\Models\Tag;
use App\Models\Todo;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TodoController extends Controller
{
    public function index()
    {
        $tags = Tag::groupBy('name')->pluck('name')->take(5);
        $todos = Todo::with(['tags' => function ($query) {
        }])->where('todos.user', Auth::id())
            ->orderBy('todos.id', 'DESC')->paginate(5);
        return view('todos.index', [
            'todos' => $todos, 'tags' => $tags
        ]);
    }

    public function create()
    {
        return view('todos.create');
    }

    public function store(TodoRequest $request)
    {
        $request->validated();
        Todo::create([
            'title' => $request->title,
            'body' => $request->body,
            'is_active' => 0,
            'image' => 'default.jpg',
            'user' => Auth::id(),
            'created_at' => \Carbon\Carbon::now()->timestamp,
            'updated_at' => \Carbon\Carbon::now()->timestamp
        ]);
        $request->session()->flash('alert-success', 'Todo Created Successfully');
        return to_route('todos.index');
    }

    public function submit(TodoRequest $request)
    {
        $request->validated();
        Todo::create([
            'title' => $request->title,
            'body' => $request->body,
            'is_active' => 0,
            'image' => 'default.jpg',
            'user' => Auth::id(),
            'created_at' => \Carbon\Carbon::now()->timestamp,
            'updated_at' => \Carbon\Carbon::now()->timestamp
        ]);
        $request->session()->flash('alert-success', 'Todo Created Successfully');
        return to_route('todos.index');
    }

    public function share($id)
    {
        SharedTodo::create([
            'fromId' => Auth::id(),
            'toId' => $id,
            'created_at' => \Carbon\Carbon::now()->timestamp,
            'updated_at' => \Carbon\Carbon::now()->timestamp
        ]);
        session()->flash('alert-success', 'Shared Successfully');
        return to_route('todos.index');
    }

    public function show($id)
    {
        $query = Todo::with(['tags' => function ($query) {

        }])->where('todos.id', $id)->get()->first();
        if (!$query) {
            return to_route('todos.index')->withErrors([
                'error' => 'Unable to locate the Todo'
            ]);
        }
        return view('todos.show', ['todo' => $query]);
    }

    public function search(SearchRequest $request)
    {
        $request->validated();
        $tags = Tag::groupBy('name')->pluck('name')->take(5);
            if(!empty($request->tag)){
                $todos = Todo::whereHas('tags', function ($query) use ($request) {
                $query->where('name', '=', $request->tag)
                    ->where('todos.user', Auth::id())
                    ->where('todos.title', 'like' , '%' . $request->search . '%')
                    ->orwhere('todos.body', 'like' , '%' . $request->search . '%');
                })->paginate(5);
            } else {
                $todos = Todo::with(['tags' => function ($query) {
                }])->where('todos.user', Auth::id())
                    ->where('todos.title', 'like' , '%' . $request->search . '%')
                    ->orwhere('todos.body', 'like' , '%' . $request->search . '%')->paginate(5);
            }
        return view('todos.index', [
            'todos' => $todos, 'tags' => $tags
        ]);
    }
}
