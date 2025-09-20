<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
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
Route::middleware(['auth:sanctum', 'isAdmin'])->group(function () {
    Route::post('/admin/rooms', [RoomController::class, 'store']);
    Route::put('/admin/rooms/{id}', [RoomController::class, 'update']);
    Route::delete('/admin/rooms/{id}', [RoomController::class, 'destroy']);
});

//Bookings
// User: cần đăng nhập
// Khách tạo bookings
// Khách xem lại booking của mình
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/bookings/my', [BookingController::class, 'myBookings']);
    Route::get('/bookings/{id}/delete', [BookingController::class, 'destroy']);
});

// CRUD bookings cho admin
// Admin: cần đăng nhập + isAdmin
// Xem toàn bộ danh sách bookings và đổi trạng thái booking
Route::middleware(['auth:sanctum', 'isAdmin'])->group(function () {
    Route::get('/admin/bookings', [BookingController::class, 'index']);
    Route::put('/admin/bookings/{id}', [BookingController::class, 'update']);
});

//Contacts
// User gửi liên hệ (không cần login)
Route::post('/contacts', [ContactController::class, 'store']);

// CRUD của admin
// Hiển thị liên hệ và xóa
Route::middleware(['auth:sanctum', 'isAdmin'])->group(function () {
    Route::get('/admin/contacts', [ContactController::class, 'index']);
    Route::delete('/admin/delete/{id}', [ContactController::class, 'destroy']);
});
