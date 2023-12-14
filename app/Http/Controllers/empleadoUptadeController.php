<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class empleadoUptadeController extends Controller
{
    public function updatecontemg(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'n_coe' => 'required|string',
            'csag' => 'required|string',
            't_cem' => 'required|string',
            'id_cem' => 'required|integer',
        ]);

        if ($validator->fails()) {
            $response = array(
                'error' => true,
                'message' => 'Error en el contenido JSON',
            );
            return response()->json($response, 422);
        }


        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            $datosModel = $request->all();
            try {
                $affectedRows = DB::table('contacto_emergencia')
                    ->where('id_cem', $datosModel['id_cem'])
                    ->update([
                        'n_coe' => $datosModel['n_coe'],
                        'csag' => $datosModel['csag'],
                        't_cem' => $datosModel['t_cem'],
                    ]);

                if ($affectedRows > 0) {
                    $response = array(
                        'error' => false,
                        'message' => 'Contacto de emergencia actualizado con éxito',
                    );
                    return response()->json($response, 200);
                } else {
                    $response = array(
                        'error' => true,
                        'message' => 'Ocurrió un error al actualizar el contacto de emergencia',
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
        } else {
            return response()->json([
                'error' => true,
                'status' => 'error',
                'message' => 'No autorizado',
                'data' => [],
            ], 401);
        }
    }
    public function updateempleadoinfoone(Request $request)
    {

        $data = $request->all();

        $validator = Validator::make($data, [
            'id_em' => 'required|integer',
            'id_doc' => 'required|integer',
            'documento' => 'required|string',
            'n_em' => 'required|string',
            'a_em' => 'required|string',
            'eml_em' => 'required|string',
            'dir_em' => 'required|string',
            'lic_emp' => 'required|string',
            'lib_em' => 'required|string',
            'tel_em' => 'required|string',
            'barloc_em' => 'required|string',
            'id_rh' => 'required|integer',
            'contrato' => 'required|string',
            'id_pens' => 'required|integer',
            'id_eps' => 'required|integer',
            'id_arl' => 'required|integer',
            'id_ces' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'status' => 'error',
                'message' => 'Validation failed',
                'data' => $validator->errors(),
            ], 422);
        }

        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            try {
                $result = DB::table('empleado')
                    ->where('id_em', $data["id_em"])
                    ->update([
                        'id_doc' => $data["id_doc"],
                        'documento' => $data["documento"],
                        'n_em' => $data["n_em"],
                        'a_em' => $data["a_em"],
                        'eml_em' => $data["eml_em"],
                        'dir_em' => $data["dir_em"],
                        'lic_emp' => $data["lic_emp"],
                        'lib_em' => $data["lib_em"],
                        'tel_em' => $data["tel_em"],
                        'barloc_em' => $data["barloc_em"],
                        'id_rh' => $data["id_rh"],
                        'contrato' => $data["contrato"],
                        'id_pens' => $data["id_pens"],
                        'id_eps' => $data["id_eps"],
                        'id_arl' => $data["id_arl"],
                        'id_ces' => $data["id_ces"]
                    ]);

                if ($result) {
                    return response()->json([
                        'error' => false,
                        'status' => 'success',
                        'message' => 'Update successful',
                        'data' => [],
                    ], 200);
                } else {
                    return response()->json([
                        'error' => true,
                        'status' => 'error',
                        'message' => 'No update was made',
                        'data' => [],
                    ], 200);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'status' => 'error',
                    'message' => 'metodo no valido' . $e->getMessage(),
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
    public function updateestadoempleado(Request $request)
    {

        $data = $request->all();

        $validator = Validator::make($data, [
            'id_em' => 'required|integer',
            'estado' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'status' => 'error',
                'message' => 'Validation failed',
                'data' => $validator->errors(),
            ], 422);
        }
        $data = $request->all();
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            try {
                $result = DB::table('empleado')
                    ->where('id_em', $data["id_em"])
                    ->update([
                        'estado' => $data["estado"]
                    ]);

                if ($result) {
                    return response()->json([
                        'error' => false,
                        'status' => 'success',
                        'message' => 'Update successful',
                        'data' => [],
                    ], 200);
                } else {
                    return response()->json([
                        'error' => true,
                        'status' => 'error',
                        'message' => 'No update was made',
                        'data' => [],
                    ], 200);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'status' => 'error',
                    'message' => 'metodo no valido' . $e->getMessage(),
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
    public function updateperfil(Request $request)
    {

        $data = $request->all();

        $validator = Validator::make($data, [
            'id_em' => 'required|integer',
            'n_em' => 'string',
            'a_em' => 'string',
            'eml_em' => 'email',
            'dir_em' => 'string',
            'lic_emp' => 'string',
            'tel_em' => 'string',
            'barloc_em' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors(),
            ], 400);
        }
        $data = $request->all();
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            try {
                $result = DB::table('empleado')
                    ->where('id_em', $data["id_em"])
                    ->update([
                        'n_em' => $data["n_em"],
                        'a_em' => $data["a_em"],
                        'eml_em' => $data["eml_em"],
                        'dir_em' => $data["dir_em"],
                        'lic_emp' => $data["lic_emp"],
                        'tel_em' => $data["tel_em"],
                        'barloc_em' => $data["barloc_em"]
                    ]);

                if ($result) {
                    return response()->json([
                        'error' => false,
                        'status' => 'success',
                        'message' => 'Update successful',
                        'data' => [],
                    ], 200);
                } else {
                    return response()->json([
                        'error' => true,
                        'status' => 'error',
                        'message' => 'No update was made',
                        'data' => [],
                    ], 200);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'status' => 'error',
                    'message' => 'metodo no valido' . $e->getMessage(),
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
    public function updaterol(Request $request)
    {

        $data = $request->all();

        // Definir las reglas de validación
        $rules = [
            'id_em' => 'required|integer',
            'id_rol' => 'required|integer',
        ];

        // Crear el validador
        $validator = Validator::make($data, $rules);

        // Verificar si la validación falló
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => 'Error en el contenido JSON',
                'errors' => $validator->errors(),
            ], 400);
        }

        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            try {
                // Iniciar la transacción
                DB::beginTransaction();

                // Obtener el id_log asociado al id_empleado
                $id_log = DB::table('login')
                    ->where('id_em', $data["id_em"])
                    ->value('id_log');

                if ($id_log) {
                    // Actualizar el id_rol en la tabla user_rol
                    DB::table('user_rol')
                        ->where('id_log', $id_log)
                        ->update(['id_rol' => $data["id_rol"]]);

                    // Confirmar la transacción
                    DB::commit();

                    return response()->json([
                        'error' => false,
                        'message' => 'Rol actualizado correctamente',
                    ], 200);
                } else {
                    // Deshacer la transacción en caso de error
                    DB::rollBack();

                    return response()->json([
                        'error' => true,
                        'message' => 'Ocurrió un error al actualizar el Rol',
                    ], 500);
                }
            } catch (\Exception $e) {
                // Deshacer la transacción en caso de error
                DB::rollBack();

                return response()->json([
                    'error' => true,
                    'message' => 'Método de solicitud no válido: ' . $e->getMessage(),
                ], 400);
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

    public function deletecontemg(Request $request)
    {

        $data = $request->all();
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            if ($data !== null && isset($data['id_cem'])) {
                $id = $data['id_cem'];
                $deleted = DB::table('contacto_emergencia')->where('id_cem', $id)->delete();

                if ($deleted > 0) {
                    return response()->json([
                        'error' => false,
                        'message' => 'Contacto de emergencia eliminado con éxito',
                    ]);
                } else {
                    return response()->json([
                        'error' => true,
                        'message' => 'Ocurrió un error al eliminar el contacto de emergencia',
                    ]);
                }
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'Error en el contenido JSON o falta el parámetro "id"',
                ]);
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
