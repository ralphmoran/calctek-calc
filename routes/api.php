<?php

use App\Http\Controllers\CalculationController;
use Illuminate\Support\Facades\Route;

Route::post('/calculations', [CalculationController::class, 'store']);
Route::get('/calculations', [CalculationController::class, 'index']);
Route::delete('/calculations/{calculation}', [CalculationController::class, 'destroy']);
Route::delete('/calculations', [CalculationController::class, 'clear']);
