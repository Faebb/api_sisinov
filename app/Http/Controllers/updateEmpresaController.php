<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class updateEmpresaController extends Controller
{
    public function updateEmpresa(Request $request, $id)
    {

        $update = Empresa::find($id);

        if (!$update) {
            return response()->json(['error' => 'Empresa no encontrado'], 404);
        }

        $data = $request->all();

        $validator = Validator::make($data, [
            'Nit_E' => 'string|max:14',
            'Nom_E' => 'string|max:85',
            'Eml_E' => 'email|max:50',
            'Nom_Rl' => 'string|max:85',
            'ID_Doc' => 'integer|digits:1',
            'CC_Rl' => 'string|max:11',
            'telefonoGeneral' => 'string|max:30',
            'Val_E' => 'string|max:15',
            'Est_E' => 'string|max:10',
            'Fh_Afi' => 'date',
            'fechaFinalizacion' => 'date',
            'COD_SE' => 'string|max:6',
            'COD_AE' => 'string|max:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $update->fill($data);
        $update->save();

        if ($update->save()) {
            return response()->json(['message' => 'Empresa actualizada con éxito'], 200);
        } else {
            return response()->json(['error' => 'Error al actualizar la Empresa'], 500);
        }

    }
}
