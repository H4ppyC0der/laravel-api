<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Public Routes
Route::get('/tasks', [TaskController::class, 'index']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);




//Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/task/{id}', [TaskController::class, 'show']);
    Route::post('/newtask', [TaskController::class, 'store']);
    Route::get('/task/search/{username}', [TaskController::class, 'search']);
    Route::post('/task/{id}', [TaskController::class, 'destroy']);
    Route::put('/task/{id}', [TaskController::class, 'update']);
    Route::post('/logout', [AuthController::class, 'logout']);


    
});
