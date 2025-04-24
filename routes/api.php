<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API's Post Resources
Route::apiResource('posts' , PostController::class);
// API's Categories Resources
Route::apiResource('categories' , CategoryController::class);
// API Activity Index Log
Route::get('/activity-logs' , [ActivityLogController::class , 'index']);