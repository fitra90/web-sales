<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StuffsController;
use App\Http\Controllers\OrdersController;
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
// 
//  stuff CRUD
//
Route::get('/stuffs', [StuffsController::class, 'viewAll']);
Route::get('/new-stuff', [StuffsController::class, 'viewNew']);
Route::post('/save-new-stuff', [StuffsController::class, 'saveNew']);
Route::post('/save-edit-stuff/{id}', [StuffsController::class, 'saveEdit']);
Route::get('/edit-stuff/{id}', [StuffsController::class, 'viewEdit']);
Route::get('/single-stuff/{id}', [StuffsController::class, 'viewSingle']);
Route::delete('/delete-stuff/{id}', [StuffsController::class, 'delete']);
Route::get('/menu', [StuffsController::class, 'viewMenu']);

// 
//  order CRUD
//
Route::get('/orders', [OrdersController::class, 'viewAll']);
Route::get('/new-order', [OrdersController::class, 'viewNew']);
Route::post('/save-new-order', [OrdersController::class, 'saveNew']);
Route::post('/save-edit-order/{id}', [OrdersController::class, 'saveEdit']);
Route::get('/edit-order/{id}', [OrdersController::class, 'viewEdit']);
Route::delete('/delete-order/{id}', [OrdersController::class, 'delete']);

// 
//  user CRUD
//
Route::get('/', [UsersController::class, 'home']);
Route::get('/users', [UsersController::class, 'viewAll']);
Route::get('/new-user', [UsersController::class, 'viewNew']);
Route::post('/save-new-user', [UsersController::class, 'saveNew']);
Route::post('/save-edit-user/{id}', [UsersController::class, 'saveEdit']);
Route::get('/edit-user/{id}', [UsersController::class, 'viewEdit']);
Route::delete('/delete-user/{id}', [UsersController::class, 'delete']);

//
// Login & Logout
//
Route::get('/login', [UsersController::class, 'login']);
Route::post('/process-login', [UsersController::class, 'getLogin']);
Route::get('/logout', [UsersController::class, 'logout']);