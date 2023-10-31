<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class readTelSedecontroller extends Controller
{
    public function index()
    {
        try {
            $telsede = DB::table('encargado')
                ->join('encargado_estado', 'encargado.ID_En', '=', 'encargado_estado.ID_En')
                ->join('sede', 'encargado_estado.ID_S', '=', 'sede.ID_S')
                ->select('encargado.ID_En', 'encargado.N_En', 'encargado_estado.Est_en', 'encargado.tel1', 'encargado.tel2', 'encargado.tel3')
                ->get();


            if ($telsede->isEmpty()) {
                return [
                    'status' => 'error',
                    'message' => 'No se encontraron telefonos',
                    'data' => [],
                ];
            } else {
                return [
                    'status' => 'success',
                    'message' => 'Telefonos encontrados correctamente',
                    'data' => $telsede,
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al buscar los Telefonos: ' . $e->getMessage(),
                'data' => null,
            ];
        }
    }

    public function show($id)
    {
        try {

            $resultado = DB::table('encargado')
                ->join('encargado_estado', 'encargado.ID_En', '=', 'encargado_estado.ID_En')
                ->join('sede', 'encargado_estado.ID_S', '=', 'sede.ID_S')
                ->where('sede.ID_S', $id)
                ->select('encargado.ID_En', 'encargado.N_En', 'encargado_estado.Est_en', 'encargado.tel1', 'encargado.tel2', 'encargado.tel3')
                ->get();

            if ($resultado) {
                return [
                    'status' => 'success',
                    'message' => 'Tipo de documento encontrada correctamente',
                    'data' => $resultado,
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Tipo de documento no encontrada',
                    'data' => null,
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al buscar el tipo de Documento: ' . $e->getMessage(),
                'data' => null,
            ];
        }
    }
}
