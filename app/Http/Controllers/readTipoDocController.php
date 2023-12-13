<?php

namespace App\Http\Controllers;

use App\Models\TipoDoc;
use Illuminate\Http\Request;
use App\Http\Controllers\tokenController;

class readTipoDocController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->all();
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            try {
                $tipodoc = TipoDoc::all();

                if ($tipodoc->isEmpty()) {
                    return response()->json([
                        'error' => true,
                        'status' => 'error',
                        'message' => 'No se encontraron tipo de documento',
                        'data' => [],
                    ], 404);
                } else {
                    return response()->json([
                        'error' => false,
                        'status' => 'success',
                        'message' => 'Tipos de documento encontrados correctamente',
                        'data' => $tipodoc,
                    ], 200);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'status' => 'error',
                    'message' => 'Error al buscar el tipo de documento: ' . $e->getMessage(),
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
                $resultado = TipoDoc::find($id);

                if ($resultado) {
                    return response()->json([
                        'error' => false,
                        'status' => 'success',
                        'message' => 'Tipo de documento encontrada correctamente',
                        'data' => $resultado,
                    ], 200);
                } else {
                    return response()->json([
                        'error' => true,
                        'status' => 'error',
                        'message' => 'Tipo de documento no encontrada',
                        'data' => [],
                    ], 404);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'status' => 'error',
                    'message' => 'Error al buscar el tipo de Documento: ' . $e->getMessage(),
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
}
