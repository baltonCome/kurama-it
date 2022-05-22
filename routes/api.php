<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\InterestController;
use App\Http\Controllers\FeedbackController;

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
Route::get('/users/{user:username}/jobs', [UserController::class, 'userInterests'])->name('users.show');
Route::get('/users', [UserController::class, 'index']);

Route::get('/', [JobController::class, 'index']);
Route::get('/job/{title}', [JobController::class, 'search']);

Route::get('/feedback', [FeedbackController::class, 'index']);

//Protected routes
Route::group(['middleware' => ['auth:sanctum']], function (){

    Route::post('/logout', [UserController::class, 'logout']);
    Route::put('/update/{id}', [UserController::class, 'update']);
    Route::get('/refresh', [UserController::class, 'refresh']);

    Route::post('/new-job', [JobController::class, 'store']);
    Route::put('/job/{id}', [JobController::class, 'update']);
    Route::delete('/job/{id}', [JobController::class, 'destroy']);

    Route::post('jobs/{job}/interests',[InterestController::class, 'store'])->name('jobs.interests');
    Route::delete('jobs/{job}/interests',[InterestController::class, 'destroy'])->name('jobs.interests');

    Route::post('/new-feedback', [FeedbackController::class, 'store']);
    Route::delete('/feedback/{id}', [FeedbackController::class, 'destroy']);
});

//Job parameter on InterestController - Refers to the job id of the user
Route::middleware('auth:sanctum')->get('/user', function (Request $request){

    return $request->user();
});
