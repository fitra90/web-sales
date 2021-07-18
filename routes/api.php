<?php

use App\Http\Controllers\UsersController;
use App\Http\Controllers\StuffsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [UsersController::class, 'apiLogin']);

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('/stuffs', [StuffsController::class, 'index']);
    Route::get('/logout', [UsersController::class, 'apiLogout']);
});