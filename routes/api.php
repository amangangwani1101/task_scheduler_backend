<?php

use App\Http\Controllers\AdminTaskController;
use App\Http\Controllers\UserTaskController;
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

// user - authentication 
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); 


Route::prefix('user')->group(function () {
    Route::get('tasks', [UserTaskController::class, 'index']);
    Route::post('tasks', [UserTaskController::class, 'store']);
    Route::get('tasks/{task}', [UserTaskController::class, 'show']);
    Route::put('tasks/{task}', [UserTaskController::class, 'update']);
    Route::delete('tasks/{task}', [UserTaskController::class, 'destroy']);
});

Route::prefix('admin')->group(function () {
    Route::get('tasks', [AdminTaskController::class, 'index']);
    Route::delete('tasks/{task}', [AdminTaskController::class, 'destroy']);
});
