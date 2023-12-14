<?php

namespace App\Http\Controllers;

use App\Models\Novedad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class novedadUpdateTpNovedadController extends Controller
{
    public function update(Request $request)
    {
        $data = $request->all();
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            try {
                DB::table('novedad')
                    ->where('ID_Nov', $data["ID_Nov"])
                    ->update([
                        'T_Nov' => $data["T_Nov"],
                        'Des_Nov' => $data["Des_Nov"],
                        'id_em' => $data["id_em"]
                    ]);

                return response()->json([
                    'error' => false,
                    'status' => 'success',
                    'message' => 'Update successful',
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'status' => 'error',
                    'message' => 'Update failed: ' . $e->getMessage()
                ], 500);
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
    public function updatetpnovedad(Request $request)
    {
        $data = $request->all();
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            try {
                // Actualizar la tabla 'tp_novedad'
                $affectedRows = DB::table('tp_novedad')
                    ->where('T_Nov', $data["T_Nov"])
                    ->update([
                        'Nombre_Tn' => $data["Nombre_Tn"],
                        'descrip_Tn' => $data["descrip_Tn"]
                    ]);

                if ($affectedRows > 0) {
                    return response()->json([
                        'error' => false,
                        'status' => 'success',
                        'message' => 'Update successful',
                    ], 200);
                } else {
                    return response()->json([
                        'error' => true,
                        'status' => 'error',
                        'message' => 'Update failed',
                    ], 500);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'status' => 'error',
                    'message' => 'Update failed: ' . $e->getMessage()
                ], 500);
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
