<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;

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

//lấy ra thông tin user
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Đăng ký
Route::post('/register', [AuthController::class, 'register']);

// Đăng nhập
Route::post('/login', [AuthController::class, 'login']);

// Đăng xuất (chỉ dành cho user đã đăng nhập)
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

//Rooms 
// Xem danh sách phòng công khai
Route::get('/rooms', [RoomController::class, 'index']);
// Xem chi tiết phòng công khai
Route::get('/rooms/{id}', [RoomController::class, 'show']);

// CRUD rooms của admin
Route::middleware('auth:sanctum', 'isAdmin')->group(function () {
    Route::post('/rooms', [RoomController::class, 'store']);
    Route::put('/rooms/{id}', [RoomController::class, 'update']);
    Route::delete('rooms/{id}', [RoomController::class, 'destroy']);
});
