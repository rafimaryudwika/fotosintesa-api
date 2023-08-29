<?php

use App\Http\Controllers\KegiatanPenilaianController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\TahapPenilaianController;
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

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::apiResource('periode', PeriodeController::class);

    Route::group(['prefix' => 'tahapan/{periodeId}'], function () {
        Route::apiResource('/', TahapPenilaianController::class)->only(['index', 'store']);
        Route::get('{tahapan}', [TahapPenilaianController::class, 'show']);
        Route::put('{tahapan}', [TahapPenilaianController::class, 'update']);
        Route::delete('{tahapan}', [TahapPenilaianController::class, 'destroy']);
    });

    Route::group(['prefix' => 'kegiatan/{periodeId}/{tahapanId}'], function () {
        Route::apiResource('/', KegiatanPenilaianController::class)->only(['index', 'store']);
        Route::get('{kegiatan}', [KegiatanPenilaianController::class, 'show']);
        Route::put('{kegiatan}', [KegiatanPenilaianController::class, 'update']);
        Route::delete('{kegiatan}', [KegiatanPenilaianController::class, 'destroy']);
    });

    Route::apiResource('users', UserController::class);
    Route::get('/user', [UserController::class, 'currentUser']);
});
