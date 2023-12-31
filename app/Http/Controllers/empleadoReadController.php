<?php

namespace App\Http\Controllers;

use App\Models\Arl;
use App\Models\Cesantia;
use App\Models\Ep;
use App\Models\Pensione;
use App\Models\Rh;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class empleadoReadController extends Controller
{
    public function readveriemlempleado(Request $request, $eml_em)
    {
        $data = $request->all();
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            try {

                $result = DB::table('empleado')->where('eml_em', $eml_em)->get();

                if ($result->isEmpty()) {
                    return response()->json([
                        'error' => false,
                        'status' => 'error',
                        'message' => 'Solicitud completada correctamente',
                        'encontrado' => false,
                    ], 200);
                } else {
                    return response()->json([
                        'error' => false,
                        'status' => 'success',
                        'message' => 'Solicitud completada correctamente',
                        'encontrado' => true,
                    ], 200);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'status' => 'error',
                    'message' => 'metodo no valido' . $e->getMessage()
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
    public function readverificarempleado(Request $request, $id_doc, $documento)
    {
        $data = $request->all();
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            try {
                $result = DB::table('empleado')
                    ->where('id_doc', $id_doc)
                    ->where('documento', $documento)
                    ->get();

                if ($result->isEmpty()) {
                    error_log('Empleado NO encontrado en la base de datos');
                    $response['error'] = false;
                    $response['message'] = 'Solicitud completada correctamente';
                    $response['encontrado'] = false;
                } else {
                    error_log('Empleado encontrado en la base de datos');
                    $response['error'] = false;
                    $response['message'] = 'Solicitud completada correctamente';
                    $response['encontrado'] = true;
                }
            } catch (\Exception $e) {
                $response['error'] = true;
                $response['message'] = 'Error occurred';
            }
            return response()->json($response);
        } else {
            return response()->json([
                'error' => true,
                'status' => 'error',
                'message' => 'No autorizado',
                'data' => [],
            ], 401);
        }
    }



    public function readcontemg(Request $request, $id)
    {
        $data = $request->all();
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            if (!empty($id)) {
                try {
                    $result = DB::table('contacto_emergencia')
                        ->where('id_em', $id)
                        ->get(['id_cem', 'n_coe', 'csag', 't_cem']);

                    if ($result->isEmpty()) {

                        $response['error'] = false;
                        $response['message'] = 'Solicitud completada correctamente';
                        $response['contenido'] = array();
                    } else {
                        $response['error'] = false;
                        $response['message'] = 'Solicitud completada correctamente';
                        $response['contenido'] = $result;
                    }
                } catch (\Exception $e) {
                    $response['error'] = true;
                    $response['message'] = 'Error occurred';
                }
            } else {
                $response['error'] = true;
                $response['message'] = 'Ingrese el id del empleado';
            }

            return response()->json($response);
        } else {
            return response()->json([
                'error' => true,
                'status' => 'error',
                'message' => 'No autorizado',
                'data' => [],
            ], 401);
        }
    }

    public function readminempleado(Request $request)
    {
        $data = $request->all();
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            try {
                $result = DB::table('empleado')
                    ->select('id_em', 'documento', 'n_em', 'a_em', 'eml_em', 'tel_em', 'estado')
                    ->get();

                if ($result->isEmpty()) {
                    return response()->json([
                        'error' => true,
                        'status' => 'error',
                        'message' => 'No results found',
                        'data' => [],
                    ], 404);
                } else {
                    return response()->json([
                        'error' => false,
                        'status' => 'success',
                        'data' => $result,
                    ], 200);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'status' => 'error',
                    'message' => 'metodo no valido' . $e->getMessage()
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

    public function readperfil(Request $request)
    {
        $data = $request->all();

        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            $id = $data['id_em'];

            try {
                // Obtener el perfil asociado al id_empleado
                $perfil = DB::table('empleado')
                    ->where('id_em', $id)
                    ->select('id_em', 'n_em', 'a_em', 'eml_em', 'dir_em', 'lic_emp', 'tel_em', 'barloc_em')
                    ->get();

                if ($perfil->isEmpty()) {
                    return response()->json([
                        'error' => true,
                        'message' => 'Fallo: No se encontró un perfil válido',
                    ], 404);
                } else {
                    return response()->json([
                        'error' => false,
                        'message' => 'Solicitud completada correctamente',
                        'contenido' => $perfil,
                    ], 200);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'message' => 'Error occurred: ' . $e->getMessage(),
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


    public function readempleadoone(Request $request, $id)
    {
        $data = $request->all();
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            try {
                $result = DB::table('empleado')
                    ->select('id_em', 'n_em', 'a_em', 'eml_em', 'id_rh', 'id_doc', 'documento', 'tel_em', 'barloc_em', 'dir_em', 'lib_em', 'lic_emp', 'contrato', 'id_eps', 'estado', 'id_ces', 'id_pens', 'id_arl')
                    ->where('id_em', $id)
                    ->get();

                if ($result->isEmpty()) {
                    return response()->json([
                        'error' => true,
                        'status' => 'error',
                        'message' => 'No results found',
                        'data' => [],
                    ], 404);
                } else {
                    return response()->json([
                        'error' => false,
                        'status' => 'success',
                        'data' => $result,
                    ], 200);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'status' => 'error',
                    'message' => 'metodo no valido' . $e->getMessage()
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

    public function readempleadoestado(Request $request, $id)
    {
        $data = $request->all();
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            try {
                $result = DB::table('empleado')
                    ->select('id_em', 'estado')
                    ->where('id_em', $id)
                    ->get();

                if ($result->isEmpty()) {
                    return response()->json([
                        'error' => true,
                        'status' => 'error',
                        'message' => 'No results found',
                        'data' => [],
                    ], 404);
                } else {
                    return response()->json([
                        'error' => false,
                        'status' => 'success',
                        'data' => $result,
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
    public function rol(Request $request)
    {
        $data = $request->all();
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            try {
                $rol = Rol::all();

                if ($rol->isEmpty()) {
                    return response()->json([
                        'error' => true,
                        'status' => 'error',
                        'message' => 'No se encontraron roles',
                        'data' => [],
                    ], 404);
                } else {
                    return response()->json([
                        'error' => false,
                        'status' => 'success',
                        'message' => 'Roles encontrados correctamente',
                        'data' => $rol,
                    ], 200);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'status' => 'error',
                    'message' => 'Error al buscar el rol: ' . $e->getMessage(),
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
    public function rh(Request $request)
    {
        $data = $request->all();
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            try {
                $rol = Rh::all();

                if ($rol->isEmpty()) {
                    return response()->json([
                        'error' => true,
                        'status' => 'error',
                        'message' => 'No se encontraron grupos sangineos',
                        'data' => [],
                    ], 404);
                } else {
                    return response()->json([
                        'error' => false,
                        'status' => 'success',
                        'message' => 'Grupos sanguineos encontrados correctamente',
                        'data' => $rol,
                    ], 200);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'status' => 'error',
                    'message' => 'Error al buscar el grupo sangineo: ' . $e->getMessage(),
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
    public function eps(Request $request)
    {
        $data = $request->all();
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            try {
                $eps = Ep::all();

                if ($eps->isEmpty()) {
                    return response()->json([
                        'error' => true,
                        'status' => 'error',
                        'message' => 'No se encontraron EPS',
                        'data' => [],
                    ], 404);
                } else {
                    return response()->json([
                        'error' => false,
                        'status' => 'success',
                        'message' => 'EPS encontrados correctamente',
                        'data' => $eps,
                    ], 200);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'status' => 'error',
                    'message' => 'Error al buscar la EPS: ' . $e->getMessage(),
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
    public function pensiones(Request $request)
    {
        $data = $request->all();
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            try {
                $pensiones = Pensione::all();

                if ($pensiones->isEmpty()) {
                    return response()->json([
                        'error' => true,
                        'status' => 'error',
                        'message' => 'No se encontraron pensiones',
                        'data' => [],
                    ], 404);
                } else {
                    return response()->json([
                        'error' => false,
                        'status' => 'success',
                        'message' => 'Pensiones encontrados correctamente',
                        'data' => $pensiones,
                    ], 200);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'status' => 'error',
                    'message' => 'Error al buscar la Pensiones: ' . $e->getMessage(),
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
    public function cesantias(Request $request)
    {
        $data = $request->all();
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            try {
                $cesantias = Cesantia::all();

                if ($cesantias->isEmpty()) {
                    return response()->json([
                        'error' => true,
                        'status' => 'error',
                        'message' => 'No se encontraron cesantias',
                        'data' => [],
                    ], 404);
                } else {
                    return response()->json([
                        'error' => false,
                        'status' => 'success',
                        'message' => 'Cesantias encontrados correctamente',
                        'data' => $cesantias,
                    ], 200);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'status' => 'error',
                    'message' => 'Error al buscar la cesantias: ' . $e->getMessage(),
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
    public function arl(Request $request)
    {
        $data = $request->all();
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            try {
                $arl = Arl::all();

                if ($arl->isEmpty()) {
                    return response()->json([
                        'error' => true,
                        'status' => 'error',
                        'message' => 'No se encontraron ARLs',
                        'data' => [],
                    ], 404);
                } else {
                    return response()->json([
                        'error' => false,
                        'status' => 'success',
                        'message' => 'ARLs encontrados correctamente',
                        'data' => $arl,
                    ], 200);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'status' => 'error',
                    'message' => 'Error al buscar las ARLs: ' . $e->getMessage(),
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
    public function readveritelaggempleado(Request $request, $tel_em)
    {
        $data = $request->all();
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            try {

                $result = DB::table('empleado')->where('tel_em', $tel_em)->get();

                if ($result->isEmpty()) {
                    return response()->json([
                        'error' => false,
                        'status' => 'error',
                        'message' => 'Solicitud completada correctamente',
                        'encontrado' => false,
                    ], 200);
                } else {
                    return response()->json([
                        'error' => false,
                        'status' => 'success',
                        'message' => 'Solicitud completada correctamente',
                        'encontrado' => true,
                    ], 200);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'status' => 'error',
                    'message' => 'metodo no valido' . $e->getMessage()
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
    public function readveritelempleado(Request $request, $t_cem)
    {
        $data = $request->all();
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            try {

                $result = DB::table('contacto_emergencia')->where('t_cem', $t_cem)->get();

                if ($result->isEmpty()) {
                    return response()->json([
                        'error' => false,
                        'status' => 'error',
                        'message' => 'Solicitud completada correctamente',
                        'encontrado' => false,
                    ], 200);
                } else {
                    return response()->json([
                        'error' => false,
                        'status' => 'success',
                        'message' => 'Solicitud completada correctamente',
                        'encontrado' => true,
                    ], 200);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'status' => 'error',
                    'message' => 'metodo no valido' . $e->getMessage()
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
    public function readempleadorol(Request $request, $id)
    {
        $data = $request->all();
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            try {
                // Obtener el id_rol asociado al id_empleado
                $id_rol = DB::table('user_rol')
                    ->whereIn('id_log', function ($query) use ($id) {
                        $query->select('id_log')
                            ->from('login')
                            ->where('id_em', $id);
                    })
                    ->value('id_rol');

                if ($id_rol) {
                    return response()->json([
                        'error' => false,
                        'message' => 'Solicitud completada correctamente',
                        'id_rol' => $id_rol,
                    ], 200);
                } else {
                    return response()->json([
                        'error' => true,
                        'message' => 'No se encontró un id_rol válido',
                    ], 404);
                }
            } catch (\Exception $e) {
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
}
