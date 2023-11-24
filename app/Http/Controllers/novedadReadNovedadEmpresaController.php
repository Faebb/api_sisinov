<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class novedadReadNovedadEmpresaController extends Controller
{
    public function index()
    {
        try {
            $resultado = DB::table('empresa')
            ->where('Est_E', 0)
            ->select('id_e', 'Nom_E')
            ->get();

            if ($resultado) {
                return [
                    'status' => 'success',
                    'message' => 'Empresa encontradas correctamente',
                    'data' => $resultado,
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Empresas no encontrada',
                    'data' => null,
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al buscar la Envidencia de la novedad: ' . $e->getMessage(),
                'data' => null,
            ];
        }
    }
}
