<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIAbsensiController;
use App\Http\Controllers\APIParticipantController;

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
Route::post('/participant', [APIParticipantController::class, 'post']);
Route::get('/participants', [APIParticipantController::class, 'get']);
Route::get('/participant/{id_participant}', [APIParticipantController::class, 'getById']);

// For Absensi
Route::get('/absensis', [APIAbsensiController::class, 'get']);
Route::get('/absensi/{id_absensi}', [APIAbsensiController::class, 'getById']);
Route::put('/absensi/{id_absensi}', [APIAbsensiController::class, 'put']);




