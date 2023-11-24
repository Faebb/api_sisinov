<?php

namespace App\Http\Controllers;

use App\Models\Evidencium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class novedadCreateEvidenciaController extends Controller
{
    public function create(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'adjunto' => 'string',
            'ID_Nov' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        DB::beginTransaction();

        try {
            $evidencia = new Evidencium([
                'adjunto' => $data['adjunto'],
                'ID_Nov' => $data['ID_Nov'],
            ]);

            $evidencia->save();

            DB::commit();
            return response()->json(['message' => 'Envidencia creada con éxito'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al crear la Evidencia'], 500);
        }
    }
}
