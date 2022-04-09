<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\DiaryController;
use App\Http\Controllers\DiaryTypeController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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

Route::get('/courses', [CourseController::class, 'index']);
Route::get('/diaries', [DiaryController::class, 'index']);
Route::get('/educations', [EducationController::class, 'index']);
Route::get('/roles', [RoleController::class, 'index']);
Route::get('/users', [UserController::class, 'index']);
Route::get('/diary-types', [DiaryTypeController::class, 'index']);

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function() {
    Route::get('user', [UserController::class, 'fetch']);
    Route::post('logout', [UserController::class, 'logout']);
});
