<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LamaranController;
use App\Http\Controllers\PendaftarController;
use App\Models\Pendaftar;
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
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::post('/lamar', [LamaranController::class, 'store']);
Route::get('/lamaran', [LamaranController::class, 'getLamaranByUser']);
Route::get('/lamaran/user/{userid}', [LamaranController::class, 'getByUser']);
Route::get('/cek-lamaran', [LamaranController::class, 'cekLamaran']);

// Route::get('/lowongan/{id}/pendaftar', [LamaranController::class, 'getPendaftarByLowongan']);

Route::get('lamaran/by-lowongan/{lowongan_id}', [LamaranController::class, 'getByLowongan']);
Route::get('lamaran/lowongan/{id}', [LamaranController::class, 'getByLowongan']);

Route::get('lowongan/{id}/pendaftar', [LamaranController::class, 'getPendaftarByLowongan']);

Route::middleware('auth:sanctum')->get('/profile', [UserController::class, 'getProfile']);

Route::get('/user-profile', [UserController::class, 'profile']);