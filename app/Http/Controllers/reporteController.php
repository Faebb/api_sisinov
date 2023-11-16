<?php

namespace App\Http\Controllers;

use App\Models\Trazabilidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class reporteController extends Controller
{
    public function repnov(Request $request)
    {
        // Define reglas de validación para los parámetros de consulta
        $rules = [
            'tipoNovedad' => 'required|integer',
            'startdate' => 'required|date',
            'enddate' => 'required|date',
        ];

        // Valida los parámetros de consulta
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // Si la validación falla, devuelve una respuesta de error
            return response()->json(['error' => true, 'message' => 'Error en la URL o parámetros de consulta'], 400);
        }

        // Los parámetros de consulta son válidos, continúa con el procesamiento
        $tipoNovedad = $request->query('tipoNovedad');
        $startdate = $request->query('startdate');
        $enddate = $request->query('enddate');

        // Realiza las operaciones necesarias con estos valores

    }
}
