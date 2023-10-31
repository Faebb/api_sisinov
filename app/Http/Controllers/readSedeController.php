<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sede;
use Illuminate\Support\Facades\DB;

class readSedeController extends Controller
{
    public function index()
    {
        try {
            $sedes = Sede::all();

            if ($sedes->isEmpty()) {
                return [
                    'status' => 'error',
                    'message' => 'No se encontraron Sedes',
                    'data' => [],
                ];
            } else {
                return [
                    'status' => 'success',
                    'message' => 'Sedes encontradas correctamente',
                    'data' => $sedes,
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al buscar las Sedes: ' . $e->getMessage(),
                'data' => null,
            ];
        }
    }

    public function show($id)
    {
        try {
            $resultado = Sede::find($id);

            if ($resultado) {
                return [
                    'status' => 'success',
                    'message' => 'Sede encontrada correctamente',
                    'data' => $resultado,
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Sede no encontrada',
                    'data' => null,
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al buscar la Sede: ' . $e->getMessage(),
                'data' => null,
            ];
        }
    }
}
