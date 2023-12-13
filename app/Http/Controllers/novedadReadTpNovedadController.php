<?php

namespace App\Http\Controllers;

use App\Models\TpNovedad;
use Illuminate\Http\Request;
use App\Http\Controllers\tokenController;

class novedadReadTpNovedadController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->all();
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            try {
                $tpnov = TpNovedad::all();

                if ($tpnov->isEmpty()) {
                    return response()->json([
                        'error' => true,
                        'status' => 'error',
                        'message' => 'No se encontraron tipo de Novedad',
                        'data' => [],
                    ]);
                } else {
                    return response()->json([
                        'error' => false,
                        'status' => 'success',
                        'message' => 'Tipos de NOvedad encontrados correctamente',
                        'data' => $tpnov,
                    ], 200);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'status' => 'error',
                    'message' => 'Error al buscar el tipo de Novedad: ' . $e->getMessage(),
                    'data' => [],
                ], 500);
            }
        } else {
            return response()->json([
                'error' => true,
                'status' => 'error',
                'message' => 'No autorizado',
                'data' => [],
            ], 401);
        }
    }
}
