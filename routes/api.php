<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\UserController;
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

Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/register', [AuthController::class, 'register']);

Route::group([
    'middleware' => 'auth:api'
], function ($router) {

    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::post('auth/refresh', [AuthController::class, 'refresh']);
    Route::post('auth/user', [AuthController::class, 'getLoggedUser']);

    Route::get('user', [UserController::class, 'index']);
    Route::get('user/{id}', [UserController::class, 'show']);
    Route::post('user/create-verifikator', [UserController::class, 'createVerifikator']);
    Route::put('user/{id}/promote', [UserController::class, 'promoteUser']);
    Route::post('user/{id}/verify', [UserController::class, 'verify']);

    Route::get('izin', [IzinController::class, 'index']);
    Route::post('izin', [IzinController::class, 'store']);
    Route::get('izin/{id}', [IzinController::class, 'show']);
    Route::put('izin/{id}', [IzinController::class, 'update']);
    Route::delete('izin/{id}', [IzinController::class, 'destroy']);
    Route::put('izin/{id}/accept', [IzinController::class, 'accept']);
    Route::put('izin/{id}/reject', [IzinController::class, 'reject']);
    Route::put('izin/{id}/revise', [IzinController::class, 'revise']);
    Route::put('izin/{id}/cancel', [IzinController::class, 'cancel']);

    Route::get('dashboard', [DashboardController::class, 'index']);

    Route::get('me', function() {
        return auth()->user();
    });
});

