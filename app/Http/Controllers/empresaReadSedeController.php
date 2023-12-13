<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sede;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\tokenController;

class empresaReadSedeController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->all();
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            try {
                $sedes = Sede::all();

                if ($sedes->isEmpty()) {
                    return response()->json([
                        'error' => true,
                        'status' => 'error',
                        'message' => 'No se encontraron Sedes',
                        'data' => [],
                    ], 404);
                } else {
                    return response()->json([
                        'error' => false,
                        'status' => 'success',
                        'message' => 'Sedes encontradas correctamente',
                        'data' => $sedes,
                    ], 200);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'status' => 'error',
                    'message' => 'Error al buscar las Sedes: ' . $e->getMessage(),
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

    public function show(Request $request, $id)
    {
        $data = $request->all();
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            try {
                $resultado = DB::table('sede')
                    ->where('id_e', $id)
                    ->select('ID_S', 'Dic_S', 'Sec_V', 'est_sed')
                    ->get();

                if ($resultado) {
                    return response()->json([
                        'error' => false,
                        'status' => 'success',
                        'message' => 'Sede encontrada correctamente',
                        'data' => $resultado,
                    ], 200);
                } else {
                    return response()->json([
                        'error' => true,
                        'status' => 'error',
                        'message' => 'Sede no encontrada',
                        'data' => [],
                    ], 404);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'status' => 'error',
                    'message' => 'Error al buscar la Sede: ' . $e->getMessage(),
                    'data' => [],
                ], 500);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No autorizado',
                'data' => [],
            ], 401);
        }
    }
}
