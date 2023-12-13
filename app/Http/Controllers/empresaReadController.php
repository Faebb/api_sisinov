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
                        'error' => false,
                        'status' => 'error',
                        'message' => 'No se encontraron Empresas',
                        'data' => [],
                    ], 404);
                } else {
                    return response()->json([
                        'error' => true,
                        'status' => 'success',
                        'message' => 'Empresas encontradas correctamente',
                        'data' => $empresas,
                    ], 200);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'status' => 'error',
                    'message' => 'Error al buscar las Empresas: ' . $e->getMessage(),
                    'data' => [],
                ], 500);
            }
        } else {
            return response()->json([
                'error' => true,
                'status' => 'error',
                'message' => 'No autorizado',
                'data' => [],
            ], 401);
        }
    }
    public function show(Request $request, $id)
    {
        $data = $request->all();
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            try {
                $resultado = Empresa::find($id);
                if ($resultado) {
                    return response()->json([
                        'error' => false,
                        'status' => 'success',
                        'message' => 'Empresa encontrada correctamente',
                        'data' => $resultado,
                    ],200);
                } else {
                    return response()->json([
                        'error' => true,
                        'status' => 'error',
                        'message' => 'Empresa no encontrada',
                        'data' => [],
                    ],404);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'status' => 'error',
                    'message' => 'Error al buscar la Empresa: ' . $e->getMessage(),
                    'data' => [],
                ],500);
            }
        } else {
            return response()->json([
                'error' => true,
                'status' => 'error',
                'message' => 'No autorizado',
                'data' => [],
            ], 401);
        }
    }

    public function showForNit(Request $request, $nit)
    {
        $data = $request->all();
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            try {
                $resultado = DB::table('empresa')
                    ->select('id_e')
                    ->where('Nit_E', $nit)
                    ->get();
                if ($resultado) {
                    return [
                        'error' => false,
                        'status' => 'success',
                        'message' => 'Empresa encontrada correctamente',
                        'data' => $resultado,
                    ];
                } else {
                    return [
                        'error' => true,
                        'status' => 'error',
                        'message' => 'Empresa no encontrada',
                        'data' => null,
                    ];
                }
            } catch (\Exception $e) {
                return [
                    'error' => true,
                    'status' => 'error',
                    'message' => 'Error al buscar la Empresa: ' . $e->getMessage(),
                    'data' => null,
                ];
            }
        } else {
            return response()->json([
                'error' => true,
                'status' => 'error',
                'message' => 'No autorizado',
                'data' => null,
            ], 401);
        }
    }
}
