<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View{
        $users = User::with(['sharedTodo' => function ($query) {
        }])->orderBy('id', 'DESC');
        return view('users.index', [
            'users' => $users->paginate(1)
        ]);
    }
    public function view($id): View{
        $users = User::with(['sharedTodo', 'todos.tags' => function ($query) {
        }])->where('users.id', $id)->get()->first();
        return view('users.view', [
            'users' => $users
        ]);
    }
}
