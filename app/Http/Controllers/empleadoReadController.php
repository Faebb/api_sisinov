<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class empleadoReadController extends Controller
{
    public function readveriemlempleado($eml_em)
    {
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
    }
    public function readverificarempleado($id_doc, $documento)
    {


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
    }



    public function readcontemg($id)
    {
        if (!empty($id)) {
            try {
                $result = DB::table('contacto_emergencia')
                    ->where('id_em', $id)
                    ->get(['ID_CEm', 'N_CoE', 'Csag', 'T_CEm']);

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
    }

    public function readminempleado()
    {
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
    }

    public function readempleadoone($id)
    {
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
    }

    public function readempleadoestado($id)
    {
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
    }

    public function readperfil(Request $request)
    {
        $data = $request->all();
        $id = $data['id'];
        try {
            $result = DB::table('empleado')
                ->select('id_em', 'n_em', 'a_em', 'eml_em', 'dir_em', 'lic_emp', 'tel_em', 'barloc_em')
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
    }

   
    
}
