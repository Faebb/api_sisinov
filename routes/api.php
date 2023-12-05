<?php

//empresa
use App\Http\Controllers\empresaCreateController;
use App\Http\Controllers\empresaCreateEncargadoController;
use App\Http\Controllers\empresaCreateSedeController;
use App\Http\Controllers\empresaReadController;

use App\Http\Controllers\empleadoCreateController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\updateEncargadoEstController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\novedadReadController;
use App\Http\Controllers\novedadCreateController;
use App\Http\Controllers\novedadCreateEvidenciaController;
use App\Http\Controllers\novedadCreateTpNovedadController;
use App\Http\Controllers\novedadReadEmpleadoController;
use App\Http\Controllers\novedadReadEvidenciaController;
use App\Http\Controllers\novedadReadNovedadEmpresaController;
use App\Http\Controllers\novedadReadNovedadSedeaController;
use App\Http\Controllers\novedadReadTpNovedadController;
use App\Http\Controllers\novedadUpdateTpNovedadController;
use App\Http\Controllers\readSedeController;
use App\Http\Controllers\readTelSedecontroller;
use App\Http\Controllers\readTipoDocController;
use App\Http\Controllers\reporteController;
use App\Http\Controllers\updateEmpresaController;
use App\Http\Controllers\updateEncargadoController;
use App\Http\Controllers\updateEstadoSedeController;
use App\Http\Controllers\updateSedeController;


Route::group([], function () {
    //metodos post
    Route::post('/fastempresa', [empresaCreateController::class, 'createFastEmpresa']);
    Route::post('/empresa', [empresaCreateController::class, 'createEmpresa']);
    Route::post('/sede', [empresaCreateSedeController::class, 'createSede']);
    Route::post('/encargado', [empresaCreateEncargadoController::class, 'createEncargado']);
    //metodos get
    Route::get('/empresas', [empresaReadController::class, 'index']);
    Route::get('/empresa/{id}', [empresaReadController::class, 'show']);
    Route::get('/empresas/{nit}', [empresaReadController::class, 'showForNit']);
    Route::get('/sede', [empresaReadSedeController::class, 'index']);
    Route::get('/sede/{id}', [empresaReadSedeController::class, 'show']);
    Route::get('/tdoc', [readTipoDocController::class, 'index']);
    Route::get('/tdoc/{id}', [readTipoDocController::class, 'show']);
    Route::get('telsede', [readTelSedecontroller::class, 'index']);
    Route::get('telsede/{id}', [readTelSedecontroller::class, 'show']);
    //metodos put
    Route::put('empresa/{id}', [updateEmpresaController::class, 'updateEmpresa']);
    Route::put('sede/{id}', [updateSedeController::class, 'updateSede']);
    Route::put('estadosede/{id}', [updateEstadoSedeController::class, 'updateEstSede']);
    Route::put('encargado/{id}', [updateEncargadoController::class, 'updateEncargado']);
    Route::put('encargadoestado/{id}', [updateEncargadoEstController::class, 'updateEncargadoEst']);
})->name('Empresa');

//logn
Route::group([], function(){
    //metodos post
    Route::post('/login', [loginController::class, 'login']);
    Route::post('/verifpass', [loginController::class, 'verifpass']);
    Route::post('/changepass' , [loginController::class, 'changepass']);
})->name('Login'); 

//Novedad
Route::group([], function(){
    //metodos post
    Route::post('/novedad', [novedadCreateController::class, 'create']);
    Route::post('/novedadevidencia', [novedadCreateEvidenciaController::class, 'create']);
    Route::post('/tpnov', [novedadCreateTpNovedadController::class, 'create']);
    //metods get
    Route::get('/novedad', [novedadReadController::class, 'index']);
    Route::get('/novedad/{id}', [novedadReadController::class, 'show']);
    Route::get('/tpnov', [novedadReadTpNovedadController::class, 'index']);
    Route::get('/evidencia/{id}', [novedadReadEvidenciaController::class, 'show']);
    Route::get('/novedadempresa', [novedadReadNovedadEmpresaController::class, 'index']);
    Route::get('/novedadsede/{id}', [novedadReadNovedadSedeaController::class, 'show']);
    Route::get('/novedadempleados', [novedadReadEmpleadoController::class, 'index']);
    //metodos put
    Route::put('/novedad/{id}', [novedadUpdateTpNovedadController::class, 'update']);
})->name('Novedad'); 



//Empleado
Route::group([], function(){
    //metodos post
    Route::post('/empleado', [empleadoCreateController::class, 'create']);
    Route::post('/verifpass', [loginController::class, 'verifpass']);
    Route::post('/changepass' , [loginController::class, 'changepass']);
})->name('Empleado'); 

//Reportes
Route::group([], function () {
    Route::get('/reporte-novedad', [reporteController::class, 'repnov']);
})->name('Reporte');
