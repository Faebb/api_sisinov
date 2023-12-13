<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\tokenController;

class readTelSedecontroller extends Controller
{
    public function index(Request $request)
    {
        $data = $request->all();
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            try {
                $telsede = DB::table('encargado')
                    ->join('encargado_estado', 'encargado.ID_En', '=', 'encargado_estado.ID_En')
                    ->join('sede', 'encargado_estado.ID_S', '=', 'sede.ID_S')
                    ->select('encargado.ID_En', 'encargado.N_En', 'encargado_estado.Est_en', 'encargado.tel1', 'encargado.tel2', 'encargado.tel3')
                    ->get();


                if ($telsede->isEmpty()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'No se encontraron telefonos',
                        'data' => [],
                    ], 404);
                } else {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Telefonos encontrados correctamente',
                        'data' => $telsede,
                    ], 200);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error al buscar los Telefonos: ' . $e->getMessage(),
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

    public function show(Request $request, $id)
    {
        $data = $request->all();
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            try {

                $resultado = DB::table('encargado')
                    ->join('encargado_estado', 'encargado.ID_En', '=', 'encargado_estado.ID_En')
                    ->join('sede', 'encargado_estado.ID_S', '=', 'sede.ID_S')
                    ->where('sede.ID_S', $id)
                    ->select('encargado.ID_En', 'encargado.N_En', 'encargado_estado.Est_en', 'encargado.tel1', 'encargado.tel2', 'encargado.tel3')
                    ->get();

                if ($resultado) {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Tipo de documento encontrada correctamente',
                        'data' => $resultado,
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Tipo de documento no encontrada',
                        'data' => [],
                    ], 404);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error al buscar el tipo de Documento: ' . $e->getMessage(),
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
