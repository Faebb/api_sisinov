<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class empresaReadController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->all();

        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            try {
                $empresas = Empresa::all();
    
                if ($empresas->isEmpty()) {
                    return [
                        'status' => 'error',
                        'message' => 'No se encontraron Empresas',
                        'data' => [],
                    ];
                } else {
                    return [
                        'status' => 'success',
                        'message' => 'Empresas encontradas correctamente',
                        'data' => $empresas,
                    ];
                }
            } catch (\Exception $e) {
                return [
                    'status' => 'error',
                    'message' => 'Error al buscar las Empresas: ' . $e->getMessage(),
                    'data' => null,
                ];
            }
        } else {
            return [
                'status' => 'error',
                'message' => 'No autorizado',
                'data' => null,
            ];
        }
        
    }
    public function show( $id)
    {
        try {
            $resultado = Empresa::find($id);
            if ($resultado) {
                return [
                    'status' => 'success',
                    'message' => 'Empresa encontrada correctamente',
                    'data' => $resultado,
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Empresa no encontrada',
                    'data' => null,
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al buscar la Empresa: ' . $e->getMessage(),
                'data' => null,
            ];
        }
    }

    public function showForNit(Request $request, $nit)
    {
        try {
            $valor = $request->input('valor');
            $resultado = DB::table('empresa')
                            ->select('id_e')
                            ->where('Nit_E', $nit)
                            ->get();
            if ($resultado) {
                return [
                    'status' => 'success',
                    'message' => 'Empresa encontrada correctamente',
                    'data' => $resultado,
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Empresa no encontrada',
                    'data' => null,
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al buscar la Empresa: ' . $e->getMessage(),
                'data' => null,
            ];
        }
    }
}
