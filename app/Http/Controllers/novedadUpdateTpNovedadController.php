<?php

namespace App\Http\Controllers;

use App\Models\Novedad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class novedadUpdateTpNovedadController extends Controller
{
    public function update(Request $request, $id)
    {

        $update = Novedad::find($id);

        if (!$update) {
            return response()->json(['error' => 'Novedad no encontrada'], 404);
        }

        $data = $request->all();

        $validator = Validator::make($data, [
            'T_Nov' => 'integer',
            'Des_Nov' => 'string|max:255',
            'id_em' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $update->fill($data);
        $update->save();

        if ($update->save()) {
            return response()->json(['message' => 'Novedad actualizada con éxito'], 200);
        } else {
            return response()->json(['error' => 'Error al actualizar la Novedad'], 500);
        }

    }
}
