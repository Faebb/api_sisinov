<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class novedadReadEmpleadoController extends Controller
{
    public function index()
    {
        try {
            $resultado = DB::table('empleado')
            ->select('id_em', DB::raw("CONCAT(n_em, ' ', a_em) AS Nombre_Completo_Empleado"))
            ->where('estado', '=', 0)
            ->get();
            if ($resultado) {
                return [
                    'status' => 'success',
                    'message' => 'Empleados encontradas correctamente',
                    'data' => $resultado,
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'empleados no encontrada',
                    'data' => null,
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al buscar el empleado: ' . $e->getMessage(),
                'data' => null,
            ];
        }
    }
}
