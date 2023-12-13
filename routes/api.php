<?php

//empresa

use App\Http\Controllers\empleadoController;
use App\Http\Controllers\empresaCreateController;
use App\Http\Controllers\empresaCreateEncargadoController;
use App\Http\Controllers\empresaCreateSedeController;
use App\Http\Controllers\empresaReadController;
use App\Http\Controllers\empleadoCreateController;
use App\Http\Controllers\empleadoReadController;
use App\Http\Controllers\empleadoUptadeController;
use App\Http\Controllers\empresaReadSedeController;
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
    Route::post('/empresas', [empresaReadController::class, 'index']);
    Route::post('/empresa/{id}', [empresaReadController::class, 'show']);
    Route::post('/empresas/{nit}', [empresaReadController::class, 'showForNit']);
    Route::post('/sede', [empresaReadSedeController::class, 'index']);
    Route::post('/sede/{id}', [empresaReadSedeController::class, 'show']);
    Route::post('/tdoc', [readTipoDocController::class, 'index']);
    Route::post('/tdoc/{id}', [readTipoDocController::class, 'show']);
    Route::post('telsede', [readTelSedecontroller::class, 'index']);
    Route::post('telsede/{id}', [readTelSedecontroller::class, 'show']);
    //metodos put
    Route::put('empresa/{id}', [updateEmpresaController::class, 'updateEmpresa']);
    Route::put('sede/{id}', [updateSedeController::class, 'updateSede']);
    Route::put('estadosede/{id}', [updateEstadoSedeController::class, 'updateEstSede']);
    Route::put('encargado/{id}', [updateEncargadoController::class, 'updateEncargado']);
    Route::put('encargadoestado/{id}', [updateEncargadoEstController::class, 'updateEncargadoEst']);
})->name('Empresa');

//login
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
    Route::put('/novedad', [novedadUpdateTpNovedadController::class, 'update']);
})->name('Novedad'); 



//Empleado
Route::group([], function(){
    //metodos post
    Route::post('/empleado', [empleadoCreateController::class, 'create']);
    Route::post('/verifpass', [loginController::class, 'verifpass']);
    Route::post('/changepass' , [loginController::class, 'changepass']);
    Route::post('/createcontemg', [empleadoCreateController::class, 'createcontemg']);
    //metodos get
    Route::get('/readveriemlempleado/{eml_em}', [empleadoReadController::class, 'readveriemlempleado']);
    Route::get('/readverificarempleado/{id_doc}/{documento}', [empleadoReadController::class, 'readverificarempleado']);
    Route::get('/readcontemg/{id}', [empleadoReadController::class, 'readcontemg']);
    Route::get('/readminempleado', [empleadoReadController::class, 'readminempleado']);
    Route::get('/readempleadoone/{id}', [empleadoReadController::class, 'readempleadoone']);
    Route::get('/readempleadoestado/{id}',[empleadoReadController::class, 'readempleadoestado']);
    Route::post('/readperfil', [empleadoReadController::class, 'readperfil']);
    //metodos put
    Route::put('/updatecontemg', [empleadoUptadeController::class, 'updatecontemg']);
    Route::put('updateempleadoinfoone',[empleadoUptadeController::class, 'updateempleadoinfoone']);
    Route::put('/updateestadoempleado', [empleadoUptadeController::class, 'updateestadoempleado']);
    Route::put('/updateperfil', [empleadoUptadeController::class, 'updateperfil']);
})->name('Empleado'); 

//Reportes
Route::group([], function () {
    Route::post('/repnov', [reporteController::class, 'repnov']);
    Route::post('repnovsector', [reporteController::class, 'repnovsector']);
    Route::post('repnovdia', [reporteController::class, 'repnovdia']);
    Route::post('/repnovhora', [reporteController::class, 'repnovhora']);
    Route::post('/repempresanov', [reporteController::class, 'repempresanov']);
    Route::post('/repsedenov', [reporteController::class, 'repsedenov']);
    Route::post('/rephistnov', [reporteController::class, 'rephistnov']);
    Route::post('/repsedetpnov', [reporteController::class, 'repsedetpnov']);
    Route::get('/readtrazabilidad', [reporteController::class, 'readtrazabilidad']);

})->name('Reporte');
