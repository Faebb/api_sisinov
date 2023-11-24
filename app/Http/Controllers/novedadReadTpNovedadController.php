<?php

namespace App\Http\Controllers;

use App\Models\TpNovedad;
use Illuminate\Http\Request;

class novedadReadTpNovedadController extends Controller
{
    public function index()
    {
        try {
            $tpnov = TpNovedad::all();

            if ($tpnov->isEmpty()) {
                return [
                    'status' => 'error',
                    'message' => 'No se encontraron tipo de Novedad',
                    'data' => [],
                ];
            } else {
                return [
                    'status' => 'success',
                    'message' => 'Tipos de NOvedad encontrados correctamente',
                    'data' => $tpnov,
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al buscar el tipo de Novedad: ' . $e->getMessage(),
                'data' => null,
            ];
        }
    }
}
