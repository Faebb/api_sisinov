<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class loginController extends Controller
{
    public function login()
    {
        try {
            $datosModel = request()->all();
            $documento = $datosModel['documento'];
            $passw = $datosModel['passw'];

            $user = DB::table('empleado')
                ->join('login', 'empleado.id_em', '=', 'login.id_em')
                ->join('user_rol', 'login.ID_Log', '=', 'user_rol.ID_Log')
                ->join('rol', 'user_rol.ID_rol', '=', 'rol.ID_rol')
                ->where('empleado.documento', $documento)
                ->where('login.passw', $passw)
                ->where('empleado.estado', 0)
                ->select('empleado.id_em', 'empleado.n_em', 'rol.ID_rol', 'rol.N_rol')
                ->first();

            if ($user) {
                return response()->json([
                    'error' => false,
                    'message' => 'Ingreso exitoso al sistema',
                    'user' => $user,
                ]);
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'Error: Credenciales incorrectas.',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Método de solicitud no válido',
            ]);
        }
    }

    public function verifpass()
    {
        try {
            $datosModel = request()->all();
            $id_em = $datosModel['id_em'];
            $passw = $datosModel['passw'];

            $user = DB::table('login')
                ->where('id_em', $id_em)
                ->where('passw', $passw)
                ->select('id_em')
                ->first();

            if ($user) {
                return response()->json([
                    'error' => false,
                    'message' => 'contraseña valida',
                    'user' => $user,
                ]);
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'Error: Credenciales incorrectas.',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Método de solicitud no válido',
            ]);
        }
    }

    public function changepass()
    {
        try {
            $datosModel = request()->all();
            $id_em = $datosModel['id_em'];
            $passw = $datosModel['passw'];

            $affected = DB::table('login')
                ->where('id_em', $id_em)
                ->update(['passw' => $passw]);

            if ($affected) {
                return response()->json([
                    'error' => false,
                    'message' => 'Cambio exitoso de contraseña',
                    'respond' => $affected,
                ]);
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'Error: No se logro cambiar la contraseña.',
                    'respond' => $affected,
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Método de solicitud no válido',
            ]);
        }
    }
}
