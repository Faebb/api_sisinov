<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Encargado;

class updateEncargadoController extends Controller
{
    public function updateEncargado(Request $request, $id)
    {
        $update = Encargado::find($id);

        if (!$update) {
            return response()->json(['error' => 'Encargado no encontrado'], 404);
        }

        $data = $request->all();

        $validator = Validator::make($data, [
            'N_En' => 'required|string|max:50',
            'tel1' => 'required|string|size:10',
            'tel2' => 'string|nullable|size:10',
            'tel3' => 'string|nullable|size:10',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $update->fill($data);
        $update->save();

        if ($update->save()) {
            return response()->json(['message' => 'Encargado actualizado con éxito'], 200);
        } else {
            return response()->json(['error' => 'Error al actualizar el Encargado'], 500);
        }
    }
}
