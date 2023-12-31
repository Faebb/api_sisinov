<?php

namespace App\Http\Controllers;

use App\Models\Novedad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\tokenController;

class novedadReadController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->all();
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            try {
                $novedades = Novedad::select([
                    'novedad.ID_Nov',
                    'emp.id_e',
                    'novedad.Fe_Nov',
                    'tp_novedad.Nombre_Tn',
                    DB::raw('COALESCE(novedad.Dic_Nov, sede.Dic_S) as Direccion'),
                    'novedad.Des_Nov',
                    DB::raw('CONCAT(em.n_em, " ", em.a_em) as Nombre'),
                ])
                    ->join('empleado as em', 'novedad.id_em', '=', 'em.id_em')
                    ->leftJoin('sede as sede', 'novedad.ID_S', '=', 'sede.ID_S')
                    ->join('empresa as emp', 'sede.id_e', '=', 'emp.id_e')
                    ->join('tp_novedad', 'novedad.T_Nov', '=', 'tp_novedad.T_Nov')
                    ->orderBy('novedad.Fe_Nov', 'desc')
                    ->get();

                if ($novedades->isEmpty()) {
                    return response()->json([
                        'error' => true,
                        'status' => 'error',
                        'message' => 'No se encontraron novedades',
                        'data' => [],
                    ], 404);
                } else {
                    return response()->json([
                        'error' => false,
                        'status' => 'success',
                        'message' => 'Novedades encontradas correctamente',
                        'data' => $novedades,
                    ], 200);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'status' => 'error',
                    'message' => 'Error al buscar las novedades: ' . $e->getMessage(),
                    'data' => [],
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
    public function show(Request $request, $id)
    {
        $data = $request->all();
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            try {
                $resultado = Novedad::select([
                    'novedad.ID_Nov',
                    'novedad.Fe_Nov',
                    'novedad.T_Nov',
                    'novedad.id_em',
                    'tp_novedad.Nombre_Tn',
                    'tp_novedad.descrip_Tn',
                    DB::raw('CASE WHEN novedad.ID_S IS NULL THEN novedad.Dic_Nov ELSE sede.Dic_S END as Direccion'),
                    'novedad.Des_Nov',
                    DB::raw('CONCAT(empleado.n_em, " ", empleado.a_em) as Nombre'),
                ])
                    ->join('tp_novedad', 'novedad.T_Nov', '=', 'tp_novedad.T_Nov')
                    ->join('empleado', 'novedad.id_em', '=', 'empleado.id_em')
                    ->leftJoin('sede', 'novedad.ID_S', '=', 'sede.ID_S')
                    ->where('novedad.ID_Nov', $id)
                    ->first();

                if ($resultado) {
                    return response()->json([
                        'error' => false,
                        'status' => 'success',
                        'message' => 'Novedad encontrada correctamente',
                        'data' => $resultado,
                    ], 200);
                } else {
                    return response()->json([
                        'error' => true,
                        'status' => 'error',
                        'message' => 'Novedad no encontrada',
                        'data' => [],
                    ],404);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'status' => 'error',
                    'message' => 'Error al buscar la novedad: ' . $e->getMessage(),
                    'data' => [],
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
