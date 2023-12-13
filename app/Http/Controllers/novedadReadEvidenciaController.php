<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\tokenController;

class novedadReadEvidenciaController extends Controller
{
    public function show(Request $request, $id)
    {
        $data = $request->all();
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            try {
                $resultado = DB::table('evidencia')
                    ->where('ID_Nov', $id)
                    ->select('id_evi', 'adjunto')
                    ->get();

                if ($resultado) {
                    return response()->json([
                        'error' => false,
                        'status' => 'success',
                        'message' => 'Evidencias encontradas correctamente',
                        'data' => $resultado,
                    ],200);
                } else {
                    return response()->json([
                        'error' => true,
                        'status' => 'error',
                        'message' => 'Evidencias no encontrada',
                        'data' => [],
                    ],404);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'status' => 'error',
                    'message' => 'Error al buscar la Envidencia de la novedad: ' . $e->getMessage(),
                    'data' => [],
                ],500);
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
