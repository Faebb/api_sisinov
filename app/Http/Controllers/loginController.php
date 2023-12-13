<?php

namespace App\Http\Controllers;

use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class loginController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->all();
        $documento = $data['documento'];
        $passw = $data['passw'];
        
        try {
            $user = DB::table('empleado')
                ->join('login', 'empleado.id_em', '=', 'login.id_em')
                ->join('user_rol', 'login.ID_Log', '=', 'user_rol.ID_Log')
                ->join('rol', 'user_rol.ID_rol', '=', 'rol.ID_rol')
                ->where('empleado.documento', $documento)
                ->where('login.passw', $passw)
                ->where('empleado.estado', 0)
                ->select('empleado.id_em', 'empleado.n_em', 'rol.ID_rol', 'rol.N_rol')
                ->first();
                //guardo id de el empleado
                $idEmpleado = $user->id_em;

            if ($user) {
                //guardo la fecha actual mas un día
                $fechaActual = \Carbon\Carbon::now();
                $fechaMasUnDia = $fechaActual->addDay();

                //genero token
                $ntoken = $this->generarTokenUnico();

                $token = new Token([
                    'id_em' => $idEmpleado,
                    'nToken' => $ntoken,
                    'fechaVencimiento' => $fechaMasUnDia,
                ]);
                $token->save();

                $Tokenf = $token->nToken;
                if ($Tokenf !== null) {
                    return response()->json([
                        'error' => false,
                        'message' => 'Ingreso exitoso al sistema',
                        'user' => $user,
                        'token' => $Tokenf
                    ]);
                }
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'Error: Credenciales incorrectas.',
                ]);
            }
        } catch (\Exception $e) {
            // Imprime el mensaje de la excepción para depuración
            dd($e->getMessage());

            // Devuelve una respuesta JSON con el mensaje de error
            return response()->json([
                'error' => true,
                'message' => 'Error desconocido: ' . $e->getMessage(),
            ]);
        }
    }

    private function generarTokenUnico()
    {
        $uniqueString = $this->generateUniqueString();
        return $this->randomCase($uniqueString);
    }

    private function generateUniqueString($length = 32)
    {
        $bytes = random_bytes($length / 2);
        return bin2hex($bytes);
    }

    private function randomCase($string)
    {
        $result = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $result .= (rand(0, 1) == 0) ? strtolower($string[$i]) : strtoupper($string[$i]);
        }
        return $result;
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
