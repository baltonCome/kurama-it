<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JobController;

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


Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/profile/{username}', [UserController::class, 'search']);

Route::get('/', [JobController::class, 'index']);
Route::get('/job/{jobs:job-title}', [JobController::class, 'search']);


//Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('/logout', [UserController::class, 'logout']);
    Route::put('/update', [UserController::class, 'update']);

    Route::post('/new-job', [JobController::class, 'store']);
    Route::put('/job/{id}', [JobController::class, 'update']);
    Route::delete('/job/{id}', [JobController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
