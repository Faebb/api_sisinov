<?php

namespace App\Http\Controllers;

use App\Models\EncargadoEstado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class updateEncargadoEstController extends Controller
{
    public function updateEncargadoEst(Request $request, $id)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'Est_en' => 'required|integer|digits:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $valor = $request->input('valor');
        $resultado = DB::table('encargado_estado')
            ->select('idEncargadoEstado')
            ->where('ID_En', $id)
            ->get();

        if ($resultado->isEmpty()) {
            return response()->json(['error' => 'Encargado no encontrado'], 404);
        }


        $update = EncargadoEstado::where('ID_En', $id)
            ->update(['Est_en' => $data['Est_en']]);

        if ($update) {
            return response()->json(['message' => 'Encargado actualizado con éxito'], 200);
        } else {
            return response()->json(['error' => 'Error al actualizar el Encargado'], 500);
        }
    }
}
