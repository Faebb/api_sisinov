<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class empresaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $empresas = Empresa::select(
                'empresa.id_e',
                'empresa.Nit_E',
                'empresa.Nom_E',
                'empresa.Eml_E',
                'empresa.Nom_Rl',
                'tipo_doc.N_TDoc as ID_Doc',
                'empresa.CC_Rl',
                'empresa.telefonoGeneral',
                'empresa.Val_E',
                DB::raw("CASE WHEN empresa.Est_E = 1 THEN 'Activo' ELSE 'Inactivo' END as Est_E"),
                'empresa.Fh_Afi',
                'empresa.fechaFinalizacion',
                'empresa.COD_SE',
                'empresa.COD_AE'
            )
                ->join('tipo_doc', 'empresa.ID_Doc', '=', 'tipo_doc.ID_Doc')
                ->get();

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
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Empresa $empresa)
    {
        try {
            $resultado = Empresa::select(
                'empresa.id_e',
                'empresa.Nit_E',
                'empresa.Nom_E',
                'empresa.Eml_E',
                'empresa.Nom_Rl',
                'tipo_doc.N_TDoc as ID_Doc',
                'empresa.CC_Rl',
                'empresa.telefonoGeneral',
                'empresa.Val_E',
                DB::raw("CASE WHEN empresa.Est_E = 1 THEN 'Activo' ELSE 'Inactivo' END as Est_E"),
                'empresa.Fh_Afi',
                'empresa.fechaFinalizacion',
                'empresa.COD_SE',
                'empresa.COD_AE'
            )
                ->join('tipo_doc', 'empresa.ID_Doc', '=', 'tipo_doc.ID_Doc')
                ->where('empresa.id_e', $empresa->id_e)
                ->first();

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


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Empresa $empresa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Empresa $empresa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empresa $empresa)
    {
        //
    }
}
