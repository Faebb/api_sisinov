<?php

namespace App\Http\Controllers;

use App\Models\TpNovedad;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class novedadCreateTpNovedadController extends Controller
{
    public function createTpNovedad (Request $request){
        $data = $request->all();

        $validator = Validator::make($data, [
            'Nombre_Tn' => 'required|string',
            'descrip_Tn' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        DB::beginTransaction();

        try {
            $tpnovedad = new TpNovedad([
                'Nombre_Tn' => $data['Nombre_Tn'],
                'descrip_Tn' => $data['descrip_Tn'],
            ]);

            $tpnovedad->save();

            DB::commit();
            return response()->json(['message' => 'Tipo de novedad creada con exito'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al crear el tipo de novedad'], 500);
        }
    }
}
