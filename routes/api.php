<?php

use App\Http\Controllers\empleadoController;
use App\Http\Controllers\empresaController;
use App\Http\Controllers\reporteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\novedadController;

Route::apiResource('/novedad', novedadController::class);
Route::apiResource('/empresa', empresaController::class);
Route::apiResource('/empleado', empleadoController::class);
Route::apiResource('/reporte', reporteController::class);
