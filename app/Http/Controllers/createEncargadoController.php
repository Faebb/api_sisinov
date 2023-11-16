<?php

namespace App\Http\Controllers;

use App\Models\Encargado;
use App\Models\EncargadoEstado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class createEncargadoController extends Controller
{
    public function createEncargado(Request $request)
    {

        $data = $request->all();

        $validator = Validator::make($data, [
            'ID_S' => 'required|integer',
            'N_En' => 'required|string|max:50',
            'tel1' => 'required|string|size:10',
            'tel2' => 'string|nullable|size:10',
            'tel3' => 'string|nullable|size:10',
            'Est_en' => 'required|max:2',
        ]);

        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }
        DB::beginTransaction();
        try {
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
                'ID_S' => $data['ID_S'],
                'Est_en' => $data['Est_en'],
            ]);
            $encargadoEstado->save();
            DB::commit();
            return response()->json(['message' => 'sede creada correctamente'], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'error al crear el encargado'], 500);
        }
    }
}
