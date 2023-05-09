<?php

namespace App\Http\Controllers;

use App\Models\SharedTodo;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index()
    {

        $users = User::with(["related" => function ($query) {
            $query->where('toId', Auth::id());
        }])->with(["related_one" => function ($query) {
            $query->where('fromId', Auth::id());
        }])->paginate(5);
        return view('users.index', [
            'users' => $users
        ]);
    }


    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $todo = SharedTodo::where('toId', $id)->where('fromId', Auth::id());
            $todo->delete();
            DB::commit();
            return to_route('users.index');
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function share($id)
    {
        DB::beginTransaction();
        try {
            SharedTodo::create([
                'fromId' => Auth::id(),
                'toId' => $id,
                'created_at' => \Carbon\Carbon::now()->timestamp,
                'updated_at' => \Carbon\Carbon::now()->timestamp
            ]);
            DB::commit();
            session()->flash('alert-success', 'Shared Successfully');
            return to_route('users.index');
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function view($id)
    {
        $users = User::with(["related" => function ($query) use ($id) {
            $query->where('toId', Auth::id())->where('fromId', $id);
        }])->with(["related_one" => function ($query) use ($id) {
            $query->where('fromId', Auth::id())->where('toId', $id);
        }])->with(['todos.tags' => function ($query) {
        }])->where('users.id', $id)->get()->first();

        if ($users != null) {
            if (count($users->related) > 0) {

            } else {
                return to_route('todos.index');
            }
        } else {
            return to_route('todos.index');
        }
        return view('users.view', [
            'users' => $users
        ]);
    }
}
