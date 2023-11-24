<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class novedadReadEvidenciaController extends Controller
{
    public function show($id)
    {
        try {
            $resultado = DB::table('evidencia')
            ->where('ID_Nov', $id)
            ->select('id_evi', 'adjunto')
            ->get();

            if ($resultado) {
                return [
                    'status' => 'success',
                    'message' => 'Evidencias encontradas correctamente',
                    'data' => $resultado,
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Evidencias no encontrada',
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
