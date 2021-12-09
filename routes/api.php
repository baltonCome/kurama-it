<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\InterestController;

/*
|------------------------------------------------------------------------
| API Routes
-------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



//Public routes
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/profile/{username}', [UserController::class, 'search']);
Route::get('/users/{user:username}/jobs', [UserController::class, 'index'])->name('users.show');

Route::get('/', [JobController::class, 'index']);
Route::get('/job/{title}', [JobController::class, 'search']);

//Protected routes
Route::group(['middleware' => ['auth:sanctum']], function (){

    Route::post('/logout', [UserController::class, 'logout']);
    Route::put('/update', [UserController::class, 'update']);

    Route::post('/new-job', [JobController::class, 'store']);
    Route::put('/job/{id}', [JobController::class, 'update']);
    Route::delete('/job/{id}', [JobController::class, 'destroy']);

    Route::post('jobs/{job}/interests',[InterestController::class, 'store'])->name('jobs.interests');
    Route::delete('jobs/{job}/interests',[InterestController::class, 'destroy'])->name('jobs.interests');
});

//Job parameter on InterestController - Refers to the job id of the user
Route::middleware('auth:sanctum')->get('/user', function (Request $request){

    return $request->user();
});
