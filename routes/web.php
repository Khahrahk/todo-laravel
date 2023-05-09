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

Route::group(['middleware' => 'auth'], function () {
    Route::get('todos/index', [TodoController::class, 'index'])->name('todos.index');
    Route::get('todos/show/{id}', [TodoController::class, 'show'])->name('todos.show');
    Route::get('todos/share/{id}', [TodoController::class, 'share'])->name('todos.share');
    Route::get('todos/create', [TodoController::class, 'create'])->name('todos.create');
    Route::post('todos/store', [TodoController::class, 'store'])->name('todos.store');
    Route::get('todos/search', [TodoController::class, 'search'])->name('todos.search');


    Route::get('todos/{id}/submit', [TodoController::class, 'submit'])->name('todos.submit');

    Route::get('todos/{id}/delete', [TodoController::class, 'delete'])->name('todos.delete');


    Route::get('todos/{id}/edit', [TodoController::class, 'edit'])->name('todos.edit');
    Route::put('todos/edit/submit', [TodoController::class, 'edit_submit'])->name('todos.edit_submit');

    Route::get('users/index', [UserController::class, 'index'])->name('users.index');
    Route::get('users/view/{id}', [UserController::class, 'view'])->name('users.view');
    Route::get('users/delete/{id}', [UserController::class, 'delete'])->name('users.delete');
    Route::get('users/share/{id}', [UserController::class, 'share'])->name('users.share');

});
