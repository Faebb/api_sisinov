<?php

namespace App\Http\Controllers;

use App\Models\Novedad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class novedadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $novedades = Novedad::select([
                'novedad.ID_Nov as ID_Novedad',
                'novedad.Fe_Nov as Fecha_Novedad',
                'tp_novedad.Nombre_Tn as Tipo_Novedad',
                DB::raw('COALESCE(novedad.Dic_Nov, sede.Dic_S) as Direccion'),
                'novedad.Des_Nov as Descripcion_Novedad',
                DB::raw('CONCAT(em.n_em, " ", em.a_em) as Nombre_Completo_Empleado'),
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


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Novedad $novedad)
    {
        try {
            $resultado = Novedad::select([
                'novedad.ID_Nov as ID_Novedad',
                'novedad.Fe_Nov as Fecha_Novedad',
                'tp_novedad.Nombre_Tn as Tipo_Novedad',
                'tp_novedad.descrip_Tn as Descripcion_Tipo',
                DB::raw('CASE WHEN novedad.ID_S IS NULL THEN novedad.Dic_Nov ELSE sede.Dic_S END as Direccion'),
                'novedad.Des_Nov as Descripcion_Novedad',
                DB::raw('CONCAT(empleado.n_em, " ", empleado.a_em) as Nombre_Completo_Empleado'),
            ])
                ->join('tp_novedad', 'novedad.T_Nov', '=', 'tp_novedad.T_Nov')
                ->join('empleado', 'novedad.id_em', '=', 'empleado.id_em')
                ->leftJoin('sede', 'novedad.ID_S', '=', 'sede.ID_S')
                ->where('novedad.ID_Nov', $novedad->ID_Nov)
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Novedad $novedad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Novedad $novedad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Novedad $novedad)
    {
        //
    }
}
