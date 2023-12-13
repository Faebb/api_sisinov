<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class novedadReadNovedadSedeaController extends Controller
{
    public function show(Request $request, $id)
    {
        $data = $request->all();
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            try {
                $resultado = DB::table('sede')
                    ->join('empresa', 'sede.id_e', '=', 'empresa.id_e')
                    ->select('sede.ID_S', 'sede.Dic_S')
                    ->where([
                        ['empresa.id_e', '=', $id],
                        ['sede.est_sed', '=', 0]
                    ])
                    ->get();

                if ($resultado) {
                    return response()->json([
                        'error' => false,
                        'status' => 'success',
                        'message' => 'Sedes encontradas correctamente',
                        'data' => $resultado,
                    ], 200);
                } else {
                    return response()->json([
                        'error' => true,
                        'status' => 'error',
                        'message' => 'Sedes no encontrada',
                        'data' => [],
                    ], 404);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'status' => 'error',
                    'message' => 'Error al buscar las Sedes de la novedad: ' . $e->getMessage(),
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
