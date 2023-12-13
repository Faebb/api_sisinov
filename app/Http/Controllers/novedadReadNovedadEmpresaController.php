<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\tokenController;

class novedadReadNovedadEmpresaController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->all();
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            try {
                $resultado = DB::table('empresa')
                    ->where('Est_E', 0)
                    ->select('id_e', 'Nom_E')
                    ->get();

                if ($resultado) {
                    return response()->json([
                        'error' => false,
                        'status' => 'success',
                        'message' => 'Empresa encontradas correctamente',
                        'data' => $resultado,
                    ], 200);
                } else {
                    return response()->json([
                        'error' => true,
                        'status' => 'error',
                        'message' => 'Empresas no encontrada',
                        'data' => [],
                    ], 404);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'status' => 'error',
                    'message' => 'Error al buscar la Envidencia de la novedad: ' . $e->getMessage(),
                    'data' => [],
                ]);
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
