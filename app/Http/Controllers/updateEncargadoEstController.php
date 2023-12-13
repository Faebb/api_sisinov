<?php

namespace App\Http\Controllers;

use App\Models\EncargadoEstado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\tokenController;

class updateEncargadoEstController extends Controller
{
    public function updateEncargadoEst(Request $request, $id)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'Est_en' => 'required|integer|digits:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            $resultado = DB::table('encargado_estado')
                ->select('idEncargadoEstado')
                ->where('ID_En', $id)
                ->get();

            if ($resultado->isEmpty()) {
                return response()->json(['error' => true, 'message' => 'Encargado no encontrado'], 404);
            }


            $update = EncargadoEstado::where('ID_En', $id)
                ->update(['Est_en' => $data['Est_en']]);

            if ($update) {
                return response()->json(['error' => false, 'message' => 'Encargado actualizado con éxito'], 200);
            } else {
                return response()->json(['error' => true, 'message' => 'Error al actualizar el Encargado'], 500);
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
