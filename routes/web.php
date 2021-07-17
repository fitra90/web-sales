<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StuffsController;
use App\Http\Controllers\UsersController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/logout', function () {
    // session_destroy();
    return redirect("/login");
});

Route::get('/login', function () {
    return view('login');
});

// 
//  stuff CRUD
//
Route::get('/stuffs', [StuffsController::class, 'viewAll']);
Route::get('/new-stuff', [StuffsController::class, 'viewNew']);
Route::post('/save-new-stuff', [StuffsController::class, 'saveNew']);
Route::post('/save-edit-stuff/{id}', [StuffsController::class, 'saveEdit']);
Route::get('/edit-stuff/{id}', [StuffsController::class, 'viewEdit']);
Route::delete('/delete-stuff/{id}', [StuffsController::class, 'delete']);

// 
//  user CRUD
//
Route::get('/users', [UsersController::class, 'viewAll']);
Route::get('/new-user', [UsersController::class, 'viewNew']);
Route::post('/save-new-user', [UsersController::class, 'saveNew']);
Route::post('/save-edit-user/{id}', [UsersController::class, 'saveEdit']);
Route::get('/edit-user/{id}', [UsersController::class, 'viewEdit']);
Route::delete('/delete-user/{id}', [UsersController::class, 'delete']);
