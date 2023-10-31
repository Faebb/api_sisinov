<?php

namespace App\Http\Controllers;

use App\Models\TipoDoc;
use Illuminate\Http\Request;
use PhpParser\Node\Scalar\Encapsed;

class readTipoDocController extends Controller
{
    public function index()
    {
        try {
            $tipodoc = TipoDoc::all();

            if ($tipodoc->isEmpty()) {
                return [
                    'status' => 'error',
                    'message' => 'No se encontraron tipo de documento',
                    'data' => [],
                ];
            } else {
                return [
                    'status' => 'success',
                    'message' => 'Tipos de documento encontrados correctamente',
                    'data' => $tipodoc,
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error al buscar el tipo de documento: ' . $e->getMessage(),
                'data' => null,
            ];
        }
    }

    public function show($id)
    {
        try {
            $resultado = TipoDoc::find($id);

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
