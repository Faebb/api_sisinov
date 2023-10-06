<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\novedadController;

Route::apiResource('/novedad', novedadController::class);