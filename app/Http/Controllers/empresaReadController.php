<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\tokenController;

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
                return response()->json([
                    'status' => 'error',
                    'message' => 'No se encontraron Empresas',
                    
                    'data' => [],
                ], 404);
            } else {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Empresas encontradas correctamente',
                    'data' => $empresas,
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al buscar las Empresas: ' . $e->getMessage(),
                'data' => null,
            ], 500);
        }
    } else {
        return response()->json([
            'status' => 'error',
            'message' => 'No autorizado',
            'data' => null,
        ], 401);
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
