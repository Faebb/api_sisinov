<?php

namespace App\Http\Controllers;

use App\Models\Sede;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class updateEstadoSedeController extends Controller
{
    public function updateEstSede(Request $request, $id)
    {

        $update = Sede::find($id);

        if (!$update) {
            return response()->json(['error' => 'Sede no encontrado'], 404);
        }

        $data = $request->all();

        $validator = Validator::make($data, [
            'est_sed' => 'required|integer|digits:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $update->fill($data);
        $update->save();

        if ($update->save()) {
            return response()->json(['message' => 'Estado de sede actualizada con éxito'], 200);
        } else {
            return response()->json(['error' => 'Error al actualizar el estado de Sede'], 500);
        }
    }
}
