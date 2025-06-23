<?php

use App\Http\Controllers\AdminLowonganController;
use App\Http\Controllers\AdminSoalController;
use App\Http\Controllers\LamaranController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSoalController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});

Route::get('pofil/get', [UserController::class, 'getProfil']);
Route::post('pofil/update', [UserController::class, 'updateProfil']);
Route::get('user/get/soal', [UserSoalController::class, 'getSoal']);
Route::get('user/soal/cek', [UserSoalController::class, 'isSend']);
Route::get('user/soal/send', [UserSoalController::class, 'sendJawaban']);
Route::get('user/lamaran/hasil', [LamaranController::class, 'lihatHasilLamaran']);

Route::get('lowongan/get', [AdminLowonganController::class, 'getLowongan']);
Route::get('lowongan/add', [AdminLowonganController::class, 'addLowongan']);
Route::get('lowongan/edit', [AdminLowonganController::class, 'editLowongan']);
Route::get('lowongan/delete', [AdminLowonganController::class, 'deleteLowongan']);
Route::get('lowongan/lamaran/acc', [AdminLowonganController::class, 'accLamaran']);
Route::get('lowongan/lamaran/batch/get', [AdminLowonganController::class, 'getBatchSoal']);
Route::get('lowongan/lamaran/mulai-seleksi', [AdminLowonganController::class, 'mulaiSeleksi']);
Route::get('lowongan/lamaran/akhiri-lowongan/cek', [AdminLowonganController::class, 'isLowonganBerakhir']);
Route::get('lowongan/lamaran/akhiri-lowongan', [AdminLowonganController::class, 'akhiriLowongan']);
Route::get('lowongan/lamaran/lihat-hasil', [AdminLowonganController::class, 'lihatHasil']);

Route::get('soal/batch/get', [AdminSoalController::class, 'getBatchSoal']);
Route::get('soal/batch/get/name', [AdminSoalController::class, 'getNameBatchByLowongan']);
Route::get('soal/batch/add', [AdminSoalController::class, 'addBatchSoal']);
Route::get('soal/batch/edit', [AdminSoalController::class, 'editBatchSoal']);
Route::get('soal/batch/delete', [AdminSoalController::class, 'deleteBatchSoal']);

Route::get('soal/batch/soal/get', [AdminSoalController::class, 'getSoal']);
Route::get('soal/batch/soal/add', [AdminSoalController::class, 'addSoal']);
Route::get('soal/batch/soal/edit', [AdminSoalController::class, 'editSoal']);
Route::get('soal/batch/soal/delete', [AdminSoalController::class, 'deleteSoal']);

