<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AbsensiController;
use App\Http\Controllers\API\ParticipantController;
use App\Http\Controllers\API\MahasiswaController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\SeksiController;
use App\Http\Controllers\API\PertemuanController;
use App\Http\Controllers\API\JurusanController;
use App\Http\Controllers\API\RuangController;
use App\Models\Mahasiswa;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// For Participant
Route::post('/participant', [ParticipantController::class, 'post']);
Route::get('/participants', [ParticipantController::class, 'get']);
Route::get('/participant/{id_participant}', [ParticipantController::class, 'getById']);

// For Absensi
Route::get('/absensis', [AbsensiController::class, 'get']);
Route::get('/absensi/{id_absensi}', [AbsensiController::class, 'getById']);
Route::put('/absensi/{id_absensi}', [AbsensiController::class, 'put']);

// For Mahasiswa
Route::get('/mahasiswas', [MahasiswaController::class, 'get']);

// For Users
Route::get('/users', [UserController::class, 'get']);

// For Seksis
Route::get('/seksis', [SeksiController::class, 'get']);

// For Pertemuans
Route::get('/pertemuans', [PertemuanController::class, 'get']);

// For Pertemuans
Route::get('/jurusans', [JurusanController::class, 'get']);

Route::get('/ruangs', [RuangController::class, 'get']);