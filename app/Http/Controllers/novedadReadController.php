<?php

namespace App\Http\Controllers;

use App\Models\Novedad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class novedadReadController extends Controller
{
    public function index()
    {
        try {
            $novedades = Novedad::select([
                'novedad.ID_Nov',
                'novedad.Fe_Nov',
                'tp_novedad.Nombre_Tn',
                DB::raw('COALESCE(novedad.Dic_Nov, sede.Dic_S) as Direccion'),
                'novedad.Des_Nov',
                DB::raw('CONCAT(em.n_em, " ", em.a_em) as Nombre'),
            ])
                ->join('empleado as em', 'novedad.id_em', '=', 'em.id_em')
                ->leftJoin('sede as sede', 'novedad.ID_S', '=', 'sede.ID_S')
                ->join('tp_novedad', 'novedad.T_Nov', '=', 'tp_novedad.T_Nov')
                ->get();    

            if ($novedades->isEmpty()) {
                return [
                    'status' => 'error',
                    'message' => 'No se encontraron novedades',
                    'data' => [],
                ];
            } else {
                return [
                    'status' => 'success',
                    'message' => 'Novedades encontradas correctamente',
                    'data' => $novedades,
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al buscar las novedades: ' . $e->getMessage(),
                'data' => null,
            ];
        }
    }
    public function show($id)
    {
        try {
            $resultado = Novedad::select([
                'novedad.ID_Nov',
                'novedad.Fe_Nov',
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
                return [
                    'status' => 'success',
                    'message' => 'Novedad encontrada correctamente',
                    'data' => $resultado,
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Novedad no encontrada',
                    'data' => null,
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al buscar la novedad: ' . $e->getMessage(),
                'data' => null,
            ];
        }
    }
}
