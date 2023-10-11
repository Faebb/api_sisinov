<?php

use App\Http\Controllers\empleadoController;
use App\Http\Controllers\empresaController;
use App\Http\Controllers\encargadoController;
use App\Http\Controllers\reporteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\novedadController;
use App\Http\Controllers\sedeController;

Route::apiResource('/novedad', novedadController::class);
Route::apiResource('/empresa', empresaController::class);
Route::apiResource('/sede', sedeController::class);
Route::apiResource('/encargado', encargadoController::class);
Route::apiResource('/empleado', empleadoController::class);
Route::apiResource('/reporte', reporteController::class);
