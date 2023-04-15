<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PaymentDetailController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/rooms',[RoomController::class,'index']);
Route::post('/addRooms', [RoomController::class, 'store']);
Route::get('/sortedAvailableRooms/{suite}', [RoomController::class, 'show']);
Route::get('/guests', [GuestController::class, 'index']);
Route::post('/addGuest', [GuestController::class, 'store']);
Route::get('/bookings', [BookingController::class, 'index']);
Route::post ('/addBooking', [BookingController::class, 'store']);
Route::get('bookedRoomDetails', [BookingController::class, 'bookedRoomDetails']);
Route::get('availableRoomDetails', [BookingController::class, 'availableRoomDetails']);
Route::get('/currentStatus', [BookingController::class, 'currentStatus']);
Route::get ('/payments', [PaymentDetailController::class, 'index']);