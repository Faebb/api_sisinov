<?php

namespace App\Http\Controllers;

use App\Models\Evidencium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\tokenController;

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
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            DB::beginTransaction();

            try {
                $evidencia = new Evidencium([
                    'adjunto' => $data['adjunto'],
                    'ID_Nov' => $data['ID_Nov'],
                ]);

                $evidencia->save();

                DB::commit();
                return response()->json(['error' => false, 'message' => 'Envidencia creada con éxito'], 201);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['error' => true, 'message' => 'Error al crear la Evidencia'], 500);
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
