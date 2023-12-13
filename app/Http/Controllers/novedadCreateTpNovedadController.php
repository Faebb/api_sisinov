<?php

namespace App\Http\Controllers;

use App\Models\TpNovedad;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\tokenController;

class novedadCreateTpNovedadController extends Controller
{
    public function create(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'Nombre_Tn' => 'required|string',
            'descrip_Tn' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            DB::beginTransaction();

        try {
            $tpnovedad = new TpNovedad([
                'Nombre_Tn' => $data['Nombre_Tn'],
                'descrip_Tn' => $data['descrip_Tn'],
            ]);

            $tpnovedad->save();

            DB::commit();
            return response()->json(['error' => false,'message' => 'Tipo de novedad creada con exito'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => true,'message' => 'Error al crear el tipo de novedad'], 500);
        }
        } else {
            return response()->json([
                'error' => true,
                'status' => 'error',
                'message' => 'No autorizado',
                'data' => [],
            ], 401);
        }
    }
}
