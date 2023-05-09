<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\TodoEditRequest;
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
        $tags = Tag::where('userId', Auth::id())->groupBy('name')->pluck('name')->take(5);
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
        DB::beginTransaction();
        try {
            $request->validated();
            if (!empty($request->image)) {
                $image = $request->file('image');
                $teaser_image = time() . '.' . $request->image->extension();
                $destinationPath = public_path('');
                $image->move($destinationPath, $teaser_image);
                $image = $teaser_image;
            } else {
                $image = 'default.jpg';
            }
            Todo::create([
                'title' => $request->title,
                'body' => $request->body,
                'is_active' => 0,
                'image' => $image,
                'user' => Auth::id(),
                'created_at' => \Carbon\Carbon::now()->timestamp,
                'updated_at' => \Carbon\Carbon::now()->timestamp
            ]);
            DB::commit();
            $request->session()->flash('alert-success', 'Todo Created Successfully');
            return to_route('todos.index');
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function submit($id)
    {
        DB::beginTransaction();
        try {
            $todo = Todo::where('id', $id);
            $todo->update([
                'is_active' => 1,
            ]);
            DB::commit();
            return to_route('todos.index');
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $todo = Todo::where('id', $id);
            $tags = Tag::where('todoId', $id);
            $tags->delete();
            $todo->delete();
            DB::commit();
            return to_route('todos.index');
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function show($id)
    {
        $query = Todo::with(['tags' => function ($query) {

        }])->where('todos.id', $id)->where('todos.user', Auth::id())->get()->first();
        if (!$query) {
            return to_route('todos.index')->withErrors([
                'error' => 'Unable to locate the Todo'
            ]);
        }
        return view('todos.show', ['todo' => $query]);
    }

    public function edit($id)
    {
        $query = Todo::with(['tags' => function ($query) {

        }])->where('todos.id', $id)->get()->first();
        if (!$query) {
            return to_route('todos.index')->withErrors([
                'error' => 'Unable to locate the Todo'
            ]);
        }
        return view('todos.edit', ['todo' => $query]);
    }

    public function edit_submit(TodoEditRequest $request)
    {
        DB::beginTransaction();
        try {
            if ($request->step[0] == "Tag") {
                $tag = Tag::create([
                    'name' => $request->tag,
                    'todoId' => $request->id,
                    'userId' => Auth::id(),
                    'created_at' => \Carbon\Carbon::now()->timestamp,
                    'updated_at' => \Carbon\Carbon::now()->timestamp
                ]);
                DB::commit();
                return to_route('todos.edit', $request->id);
            } elseif ($request->tag_select != null && $request->step[0] == "Tag_delete") {
                $tag = Tag::destroy($request->tag_select);
                DB::commit();
                return to_route('todos.edit', $request->id);
            } else {
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $teaser_image = time() . '.' . $request->image->extension();
                    $destinationPath = public_path('');
                    $image->move($destinationPath, $teaser_image);
                    $image = $teaser_image;
                } else {
                    $image = $request->image;
                }
                $todo = Todo::find($request->id);
                if (!$todo) {
                    return to_route('todos.index')->withErrors([
                        'error' => 'Unable to locate the Todo'
                    ]);
                }
                $todo->update([
                    'title' => $request->title,
                    'body' => $request->body,
                    'is_active' => $request->is_active,
                    'image' => $image
                ]);
                DB::commit();
                return to_route('todos.index');
            }
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function search(SearchRequest $request)
    {
        $request->validated();
        $tags = Tag::where('userId', Auth::id())->groupBy('name')->pluck('name')->take(5);
        if (!empty($request->tag) && !empty($request->search)) {
            $todos = Todo::whereHas('tags', function ($query) use ($request) {
                $query->where('tags.name', '=', $request->tag)
                    ->where('todos.user', Auth::id())
                    ->where('todos.title', 'like', '%' . $request->search . '%')
                    ->orwhere('todos.body', 'like', '%' . $request->search . '%');
            })->paginate(5);
        } elseif (!empty($request->tag) && empty($request->search)) {
            $todos = Todo::whereHas('tags', function ($query) use ($request) {
                $query->where('tags.name', '=', $request->tag)
                    ->where('todos.user', Auth::id());
            })->paginate(5);
        } else {
            $todos = Todo::with(['tags' => function ($query) {
            }])->where('todos.user', Auth::id())->paginate(5);
        }
        return view('todos.index', [
            'todos' => $todos, 'tags' => $tags
        ]);
    }
}
