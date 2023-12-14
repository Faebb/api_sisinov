<?php

namespace App\Http\Controllers;

use App\Models\ContactoEmergencium;
use App\Models\Empleado;
use App\Models\Login;
use App\Models\UserRol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Hashing\BcryptHasher;
class empleadoCreateController extends Controller
{
    public function create(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'id_doc' => 'required|integer',
            'documento' => 'required|string|max:10',
            'n_em' => 'required|string|max:35',
            'a_em' => 'required|string|max:35',
            'eml_em' => 'required|email|max:60',
            'f_em' => 'required|string',
            'dir_em' => 'required|string|max:255',
            'lic_emp' => 'required|string',
            'lib_em' => 'required|string',
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
        $data = $request->all();
        $token = $data['nToken'];

        //encriptador
        $passwEncriptada = bcrypt($data['passw']);


        if (app(tokenController::class)->token($token)) {
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
                    'N_CoE' => $data['n_coe'],
                    'Csag' => $data['csag'],
                    'id_em' => $idEmpleado,
                    'T_CEm' => $data['t_cem'],
                ]);

                $contactoEmergencia->save();

                //insertar tabla login

                $login = new Login([
                    'passw' => $passwEncriptada,
                    'id_em' => $idEmpleado,
                ]);

                $login->save();
                $idLogin = $login->ID_log;

                //Insertar Encargado_Estado
                $userRol = new UserRol([
                    'ID_rol' => $data['id_rol'],
                    'ID_log' => $idLogin,
                ]);
                $userRol->save();



                DB::commit();
                return response()->json(['error' => false, 'message' => 'Empleado creada con éxito'], 201); // 201 Created
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['error' => true, 'message' => 'Error al crear el Empleado'], 500); // 500 Internal Server Error
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
    public function createcontemg(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'n_coe' => 'required|string',
            'csag' => 'required|string',
            'id_em' => 'required|integer',
            't_cem' => 'required|string',
        ]);

        if ($validator->fails()) {
            $response = array(
                'error' => true,
                'message' => 'Error en el contenido JSON',
            );
            return response()->json($response, 422);
        }

        $datosModel = $request->all();

        try {
            $id = DB::table('contacto_emergencia')->insertGetId([
                'n_coe' => $datosModel['n_coe'],
                'csag' => $datosModel['csag'],
                'id_em' => $datosModel['id_em'],
                't_cem' => $datosModel['t_cem'],
            ]);

            if ($id > 0) {
                $response = array(
                    'error' => false,
                    'message' => 'Contacto de emergencia creado con éxito',
                );
                return response()->json($response, 201);
            } else {
                $response = array(
                    'error' => true,
                    'message' => 'Ocurrió un error al crear el contacto de emergencia',
                );
                return response()->json($response, 200);
            }
        } catch (\Exception $e) {
            $response = array(
                'error' => true,
                'message' => 'Método de solicitud no válido',
            );
            return response()->json($response, 500);
        }
    }
}
