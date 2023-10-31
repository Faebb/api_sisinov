<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sede;
use App\Models\Encargado;
use App\Models\EncargadoEstado;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class createSedeController extends Controller
{
    public function createSede(Request $request)
    {

        $data = $request->all();

        $validator = Validator::make($data, [
            'Dic_S' => 'required|string|max:80',
            'Sec_V' => 'required|integer|digits:1',
            'id_e' => 'required|integer',
            'N_En' => 'required|string|max:50',
            'tel1' => 'required|string|size:10',
            'tel2' => 'string|nullable|size:10',
            'tel3' => 'string|nullable|size:10',
            'Est_en' => 'required|max:2',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        DB::beginTransaction();
        try {
            $sede = new Sede([
                'Dic_S' => $data['Dic_S'],
                'Sec_V' => $data['Sec_V'],
                'est_sed' => '0',
                'id_e' => $data['id_e'],
            ]);

            $sede->save();
            $idSede = $sede->ID_S;

            $encargado = new Encargado([
                'N_En' => $data['N_En'],
                'tel1' => $data['tel1'],
                'tel2' => $data['tel2'],
                'tel3' => $data['tel3'],
            ]);
            $encargado->save();
            $idEncargado = $encargado->ID_En;

            $encargadoEstado = new EncargadoEstado([
                'ID_En' => $idEncargado,
                'ID_S' => $idSede,
                'Est_en' => $data['Est_en'],
            ]);
            $encargadoEstado->save();
            DB::commit();
            return response()->json(['message' => 'sede creada con éxito'], 201); // 201 Created  
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al crear la sede'], 500); // 500 Internal Server Error
        }
    }
}
