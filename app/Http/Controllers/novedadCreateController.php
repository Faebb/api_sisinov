<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Novedad;
use App\Models\Evidencium;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class novedadCreateController extends Controller
{
    public function createNovedadEvidencia(Request $request){
        $data = $request->all();

        $validator = Validator::make($data, [
            'Fe_Nov' => 'required|date',
            'T_Nov' => 'required|integer',
            'Dic_Nov' => 'nullable|string|max:100',
            'Des_Nov' => 'required|string|max:255',
            'id_em' => 'required|integer',
            'ID_S' => 'nullable|integer',
            'evidencia' => 'required|array',
            'evidencia.adjunto' => 'requird|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        DB::beginTransaction();

        try {
            $novedad = new Novedad([
                'Fe_Nov' => $data['Fe_Nov'],
                'T_Nov' => $data['T_Nov'],
                'Dic_Nov' => $data['Dic_Nov'],
                'Des_Nov' => $data['Des_Nov'],
                'id_em' => $data['id_em'],
                'ID_S' => $data['ID_S'],
            ]);

            $novedad->save();
            $idNovedad = $novedad->ID_Nov;

            foreach ($data['evidencia'] as $evidenciaData){
                $evidencia = new Evidencium([
                    'adjunto' => $evidenciaData['adjunto'],
                    'ID_Nov' => $idNovedad
                ]);
                $evidencia->save();
            }

            DB::commit();
            return response()->json(['message' => 'Noveddad creada con éxito'],201);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al crear la Novedad'], 500);
        }
    }
}
