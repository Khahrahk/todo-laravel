<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('todos/index', [TodoController::class, 'index'])->name('todos.index');
Route::get('todos/show/{id}', [TodoController::class, 'show'])->name('todos.show');
Route::get('todos/share/{id}', [TodoController::class, 'share'])->name('todos.share');
Route::get('todos/create', [TodoController::class, 'create'])->name('todos.create');
Route::post('todos/store', [TodoController::class, 'store'])->name('todos.store');
Route::get('todos/search', [TodoController::class, 'search'])->name('todos.search');
Route::post('todos/submit', [TodoController::class, 'submit'])->name('todos.submit');

Route::get('users/index', [UserController::class, 'index'])->name('users.index');
Route::get('users/view/{id}', [UserController::class, 'view'])->name('users.view');
