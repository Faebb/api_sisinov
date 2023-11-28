<?php

namespace App\Http\Controllers;

use App\Models\ContactoEmergencium;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class empleadoCreateController extends Controller
{
    public function createFastEmpresa(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'id_doc' => 'required|integer',
            'documento' => 'required|string|max:10',
            'n_em' => 'required|string|max:35',
            'a_em' => 'required|string|max:35',
            'eml_em' => 'required|email|max:60',
            'f_em' => 'required|date',
            'dir_em' => 'required|string|max:255',
            'lic_emp' => 'required|string|max:2',
            'lib_em' => 'required|string|max:1',
            'tel_em' => 'required|string|max:10',
            'contrato' => 'required|string|max:255',
            'barloc_em' => 'required|string|max:255',
            'id_pens' => 'required|integer',
            'id_eps' => 'required|integer',
            'id_arl' => 'required|integer',
            'id_ces' => 'required|integer',
            'id_rh' => 'required|integer',
            'estado' => 'required|integer',
            'n_coe' => 'required|string|max:75',
            'csag' => 'required|string|max:25',
            't_cem' => 'required|string|max:10',
            'passw' => 'required|string|max:50',
            'id_rol' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        DB::beginTransaction();

        try {
            // Insertar en la tabla "Empleado"
            $empleado = new Empleado([
                'id_doc' => $data['id_doc'],
                'documento' => $data['documento'],
                'n_em' => $data['n_em'],
                'a_em' => $data['a_em'],
                'eml_em' => $data['eml_em'],
                'f_em' => $data['f_em'],
                'dir_em' => $data['dir_em'],
                'lic_emp' => $data['lic_emp'],
                'lib_em' => $data['lib_em'],
                'tel_em' => $data['tel_em'],
                'contrato' => $data['contrato'],
                'barloc_em' => $data['barloc_em'],
                'id_pens' => $data['id_pens'],
                'id_eps' => $data['id_eps'],
                'id_arl' => $data['id_arl'],
                'id_ces' => $data['id_ces'],
                'id_rh' => $data['id_rh'],
                'estado' => $data['estado'],
            ]);

            $empleado->save();
            $idEmpleado = $empleado->id_em;

            // Insertar contacto de emergencia

            $contactoEmergencia = new ContactoEmergencium([
                'n_coe' => $data['n_coe'],
                'csag' => $data['csag'],
                'id_em' => $idEmpleado,
                't_cem' => $data['t_cem'],
            ]);

            $contactoEmergencia->save();

            //insertar tabla login

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
            return response()->json(['error' => false, 'message' => 'Empresa creada con éxito'], 201); // 201 Created
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => 'Error al crear la empresa'], 500); // 500 Internal Server Error
        }
    }
}
