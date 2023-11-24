<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class novedadReadNovedadSedeaController extends Controller
{
    public function show($id)
    {
        try {
            $resultado = DB::table('sede')
            ->join('empresa', 'sede.id_e', '=', 'empresa.id_e')
            ->select('sede.ID_S', 'sede.Dic_S')
            ->where([
                ['empresa.id_e', '=', $id],
                ['sede.est_sed', '=', 0]
            ])
            ->get();

            if ($resultado) {
                return [
                    'status' => 'success',
                    'message' => 'Sedes encontradas correctamente',
                    'data' => $resultado,
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Sedes no encontrada',
                    'data' => null,
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al buscar las Sedes de la novedad: ' . $e->getMessage(),
                'data' => null,
            ];
        }
    }
}
