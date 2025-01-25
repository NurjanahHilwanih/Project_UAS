<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KabkotaController;

Route::get('/', function () {
    return view('index');
});

Route::get('/kabkota/peta', [KabkotaController::class, 'index']);
Route::get('/kabkota/penduduk', [KabkotaController::class, 'penduduk']);
Route::get('/kabkota/sekolah', [KabkotaController::class, 'sekolah']);
Route::get('/kabkota/rumah_sakit', [KabkotaController::class, 'rumah_sakit']);
Route::get('/kabkota/data', [KabkotaController::class, 'data']);
