<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sede;
use Illuminate\Support\Facades\DB;

class empresaReadSedeController extends Controller
{
    public function index()
    {
        try {
            $sedes = Sede::all();

            if ($sedes->isEmpty()) {
                return [
                    'status' => 'error',
                    'message' => 'No se encontraron Sedes',
                    'data' => [],
                ];
            } else {
                return [
                    'status' => 'success',
                    'message' => 'Sedes encontradas correctamente',
                    'data' => $sedes,
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al buscar las Sedes: ' . $e->getMessage(),
                'data' => null,
            ];
        }
    }

    public function show($id)
    {
        try {
            $resultado = DB::table('sede')
            ->where('id_e', $id)
            ->select('ID_S', 'Dic_S', 'Sec_V', 'est_sed')
            ->get();

            if ($resultado) {
                return [
                    'status' => 'success',
                    'message' => 'Sede encontrada correctamente',
                    'data' => $resultado,
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Sede no encontrada',
                    'data' => null,
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al buscar la Sede: ' . $e->getMessage(),
                'data' => null,
            ];
        }
    }
}
