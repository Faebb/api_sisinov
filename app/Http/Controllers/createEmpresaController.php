<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Sede;
use App\Models\Encargado;
use App\Models\EncargadoEstado;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class createEmpresaController extends Controller
{
    public function createEmpresa(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'Nit_E' => 'required|string|max:15',
            'Nom_E' => 'required|string|max:85',
            'Eml_E' => 'required|email|max:50',
            'Nom_Rl' => 'required|string|max:85',
            'ID_Doc' => 'required|integer|digits:1',
            'CC_Rl' => 'required|string|max:10',
            'telefonoGeneral' => 'required|string|max:30',
            'Val_E' => 'nullable|integer',
            'Est_E' => 'required|string|max:10',
            'Fh_Afi' => 'date|nullable',
            'fechaFinalizacion' => 'date|nullable',
            'COD_SE' => 'required|string|max:6',
            'COD_AE' => 'required|string|max:6',
            'sedes' => 'required|array',
            'sedes.*.Dic_S' => 'required|string|max:80',
            'sedes.*.Sec_V' => 'required|integer|digits:1',
            'sedes.*.encargados' => 'required|array',
            'sedes.*.encargados.*.N_En' => 'required|string|max:50',
            'sedes.*.encargados.*.tel1' => 'required|string|size:10',
            'sedes.*.encargados.*.tel2' => 'string|nullable|size:10',
            'sedes.*.encargados.*.tel3' => 'string|nullable|size:10',
            'sedes.*.encargados.*.Est_en' => 'required|max:2', // Assuming it's a boolean field (0 or 1)
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        DB::beginTransaction();

        try {
            // Insertar en la tabla "empresa"
            $empresa = new Empresa([
                'Nit_E' => $data['Nit_E'],
                'Nom_E' => $data['Nom_E'],
                'Eml_E' => $data['Eml_E'],
                'Nom_Rl' => $data['Nom_Rl'],
                'ID_Doc' => $data['ID_Doc'],
                'CC_Rl' => $data['CC_Rl'],
                'telefonoGeneral' => $data['telefonoGeneral'],
                'Val_E' => $data['Val_E'],
                'Est_E' => $data['Est_E'],
                'Fh_Afi' => $data['Fh_Afi'],
                'fechaFinalizacion' => $data['fechaFinalizacion'],
                'COD_SE' => $data['COD_SE'],
                'COD_AE' => $data['COD_AE'],
            ]);

            $empresa->save();
            $idEmpresa = $empresa->id_e;

            // Insertar sedes
            foreach ($data['sedes'] as $sedeData) {
                $sede = new Sede([
                    'Dic_S' => $sedeData['Dic_S'],
                    'Sec_V' => $sedeData['Sec_V'],
                    'est_sed' => '0',
                    'id_e' => $idEmpresa
                ]);

                $sede->save();
                $idSede = $sede->ID_S;

                // Insertar encargados para esta sede
                foreach ($sedeData['encargados'] as $encargado) {
                    $encargadoModel = new Encargado([
                        'N_En' => $encargado['N_En'],
                        'tel1' => $encargado['tel1'],
                        'tel2' => $encargado['tel2'],
                        'tel3' => $encargado['tel3'],
                    ]);

                    $encargadoModel->save();
                    $idEncargado = $encargadoModel->ID_En;

                    //Insertar Encargado_Estado 
                    $encargadoEstado = new EncargadoEstado([
                        'ID_En' => $idEncargado,
                        'ID_S' => $idSede,
                        'Est_en' => $encargado['Est_en'],
                    ]);
                    $encargadoEstado->save();
                }
            }

            DB::commit();
            return response()->json(['message' => 'Empresa creada con éxito'], 201); // 201 Created
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al crear la empresa'], 500); // 500 Internal Server Error
        }
    }

    public function createFastEmpresa(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'Nit_E' => 'required|string|max:14',
            'Nom_E' => 'required|string|max:85',
            'Eml_E' => 'required|email|max:50',
            'Est_E' => 'required|string|max:10',
            'Fh_Afi' => 'date|nullable',
            'fechaFinalizacion' => 'date|nullable',
            'COD_SE' => 'required|string|max:6',
            'COD_AE' => 'required|string|max:6',
            'Dic_S' => 'required|string|max:80',
            'Sec_V' => 'required|integer|digits:1',
            'N_En' => 'required|string|max:50',
            'tel1' => 'required|string|size:10',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        DB::beginTransaction();

        try {
            // Insertar en la tabla "empresa"
            $empresa = new Empresa([
                'Nit_E' => $data['Nit_E'],
                'Nom_E' => $data['Nom_E'],
                'Eml_E' => $data['Eml_E'],
                'Est_E' => $data['Est_E'],
                'Fh_Afi' => $data['Fh_Afi'],
                'fechaFinalizacion' => $data['fechaFinalizacion'],
                'COD_SE' => $data['COD_SE'],
                'COD_AE' => $data['COD_AE'],
            ]);

            $empresa->save();
            $idEmpresa = $empresa->id_e;

            // Insertar sedes

            $sede = new Sede([
                'Dic_S' => $data['Dic_S'],
                'Sec_V' => $data['Sec_V'],
                'est_sed' => '0',
                'id_e' => $idEmpresa
            ]);

            $sede->save();
            $idSede = $sede->ID_S;

            // Insertar encargados para esta sede

            $encargadoModel = new Encargado([
                'N_En' => $data['N_En'],
                'tel1' => $data['tel1'],
            ]);

            $encargadoModel->save();
            $idEncargado = $encargadoModel->ID_En;

            //Insertar Encargado_Estado 
            $encargadoEstado = new EncargadoEstado([
                'ID_En' => $idEncargado,
                'ID_S' => $idSede,
                'Est_en' => '0',
            ]);
            $encargadoEstado->save();



            DB::commit();
            return response()->json(['message' => 'Empresa creada con éxito'], 201); // 201 Created
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al crear la empresa'], 500); // 500 Internal Server Error
        }
    }
}
