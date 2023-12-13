<?php

namespace App\Http\Controllers;

use App\Models\Encargado;
use App\Models\EncargadoEstado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\tokenController;

class empresaCreateEncargadoController extends Controller
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
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
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
                    'Est_en' => '0',
                ]);
                $encargadoEstado->save();
                DB::commit();
                return response()->json(['error' => false, 'message' => 'sede creada correctamente'], 201);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['error' => true, 'message' => 'error al crear el encargado'], 500);
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
