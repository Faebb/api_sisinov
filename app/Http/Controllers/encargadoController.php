<?php

namespace App\Http\Controllers;

use App\Models\Encargado;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class encargadoController extends Controller
{
    public function index()
    {
        try {
            $encargados = Encargado::select(
                'encargado.ID_En',
                'encargado.N_En',
                DB::raw("CASE WHEN encargado_estado.Est_En = 1 THEN 'Activo' ELSE 'Inactivo' END AS Est_En"),
                'encargado.tel1',
                'encargado.tel2',
                'encargado.tel3'
            )
                ->join('encargado_estado', 'encargado.ID_En', '=', 'encargado_estado.ID_En')
                ->join('sede', 'encargado_estado.ID_S', '=', 'sede.ID_S')
                ->get();

            if ($encargados->isEmpty()) {
                return [
                    'status' => 'error',
                    'message' => 'No se encontraron Encargados',
                    'data' => [],
                ];
            } else {
                return [
                    'status' => 'success',
                    'message' => 'Encargados encontrados correctamente',
                    'data' => $encargados,
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al buscar los Encargados: ' . $e->getMessage(),
                'data' => null,
            ];
        }
    }

    public function show(Encargado $encargado)
    {
        try {
            $resultado = Encargado::select(
                'encargado.ID_En',
                'encargado.N_En',
                DB::raw("CASE WHEN encargado_estado.Est_En = 1 THEN 'Activo' ELSE 'Inactivo' END AS Est_En"),
                'encargado.tel1',
                'encargado.tel2',
                'encargado.tel3'
            )
                ->join('encargado_estado', 'encargado.ID_En', '=', 'encargado_estado.ID_En')
                ->join('sede', 'encargado_estado.ID_S', '=', 'sede.ID_S')
                ->where('encargado.ID_En', $encargado->ID_En)
                ->first();

            if ($resultado) {
                return [
                    'status' => 'success',
                    'message' => 'Encargado encontrado correctamente',
                    'data' => $resultado,
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Encargado no encontrado',
                    'data' => null,
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al buscar el Encargado: ' . $e->getMessage(),
                'data' => null,
            ];
        }
    }
}
