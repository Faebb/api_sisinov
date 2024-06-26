<?php

namespace App\Http\Controllers;

use App\Models\Token;
use Illuminate\Http\Request;
use App\Models\Empresa;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\tokenController;
use Illuminate\Support\Facades\Hash;

class loginController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->all();
        $documento = $data['documento'];
        $passw = $data['passw'];

        $textoPlano = $passw;
        $passwEncriptada = bcrypt($textoPlano);

        try {
            // Consultar el usuario en la base de datos
            $user = DB::table('empleado')
                ->join('login', 'empleado.id_em', '=', 'login.id_em')
                ->join('user_rol', 'login.ID_Log', '=', 'user_rol.ID_Log')
                ->join('rol', 'user_rol.ID_rol', '=', 'rol.ID_rol')
                ->where('empleado.documento', $documento)
                ->where('empleado.estado', 0)
                ->select('login.ID_Log', 'empleado.id_em', 'empleado.n_em', 'rol.ID_rol', 'rol.N_rol', 'login.passw')
                ->first();
            // Verificar la contraseña
            if (Hash::check($passw, $user->passw)) {
                $usuario = DB::table('empleado')
                    ->join('login', 'empleado.id_em', '=', 'login.id_em')
                    ->join('user_rol', 'login.ID_Log', '=', 'user_rol.ID_Log')
                    ->join('rol', 'user_rol.ID_rol', '=', 'rol.ID_rol')
                    ->where('empleado.documento', $documento)
                    ->where('empleado.estado', 0)
                    ->select('empleado.id_em', 'empleado.n_em', 'rol.ID_rol', 'rol.N_rol')
                    ->first();
                // La contraseña es correcta...
                // Guardar la fecha actual más un día
                $fechaActual = \Carbon\Carbon::now();
                $fechaMasUnDia = $fechaActual->addDay();
                $idEmpleado = $user->id_em;
                // Generar token
                $ntoken = $this->generarTokenUnico();

                $token = new Token([
                    'id_em' => $idEmpleado,
                    'nToken' => env('JWT_SECRET') . $ntoken,
                    'fechaVencimiento' => $fechaMasUnDia,
                ]);
                $token->save();

                $Tokenf = $token->nToken;
                if ($Tokenf !== null) {
                    return response()->json([
                        'error' => false,
                        'message' => 'Ingreso exitoso al sistema',
                        'user' => $usuario,
                        'token' => $Tokenf
                    ]);
                }
            } else {
                // La contraseña es incorrecta...
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

    public function verifpass(Request $request)
    {
        $data = $request->all();
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            try {

                $id_em = $data['id_em'];
                $passw = $data['passw'];

                // Consultar el usuario en la base de datos
                $user = DB::table('login')
                    ->where('id_em', $id_em)
                    ->select('id_em', 'passw')
                    ->first();

                // Verificar la contraseña
                if (Hash::check($passw, $user->passw)) {
                    $usuario = DB::table('login')
                        ->where('id_em', $id_em)
                        ->select('id_em')
                        ->first();
                    return response()->json([
                        'error' => false,
                        'message' => 'contraseña valida',
                        'user' => $usuario,
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
        } else {
            return response()->json([
                'error' => true,
                'status' => 'error',
                'message' => 'No autorizado',
                'data' => [],
            ], 401);
        }
    }

    public function changepass(Request $request)
    {
        $data = $request->all();
        $token = $data['nToken'];

        if (app(tokenController::class)->token($token)) {
            try {
                $datosModel = request()->all();
                $id_em = $datosModel['id_em'];
                $passw = $datosModel['passw'];

                $passwEncriptada = bcrypt($passw);

                $affected = DB::table('login')
                    ->where('id_em', $id_em)
                    ->update(['passw' => $passwEncriptada]);

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
        } else {
            return response()->json([
                'error' => true,
                'status' => 'error',
                'message' => 'No autorizado',
                'data' => [],
            ], 401);
        }
    }
    public function validaEmpleado(Request $request){
        $data = $request->all();
        $documento = $data['documento'];
        $eml_em = $data['eml_em'];
        
        try {
            $empleado = DB::table('empleado')
            ->where('empleado.documento', $documento)
            ->where('empleado.eml_em', $eml_em)
            ->where('empleado.estado', 0)
            ->select('empleado.id_em')
            ->first();

            if($empleado){
                return response()->json([
                    'error' => false,
                    'status' => 'success',
                    'message' => 'El empleado fue encontrado',
                    'data' => $empleado
                ], 200);
            } else {
                return response()->json([
                    'error' => false,
                    'status' => 'error',
                    'message' => 'No se encontro empleado',
                    'data' => [],
                ], 403);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Método de solicitud no válido',
            ]);
        }
    } 

    public function recuperarPassword(Request $request, $id) {
        $data = $request->all();
        $passw = $data['password'];
        $passwEncriptada = bcrypt($passw);

        $affected = DB::table('login')
                    ->where('id_em', $id)
                    ->update(['passw' => $passwEncriptada]);

                if ($affected) {
                    return response()->json([
                        'error' => false,
                        'message' => 'Contraseña recuperada',
                        'respond' => $affected,
                    ]);
                } else {
                    return response()->json([
                        'error' => true,
                        'message' => 'Error: No se recupero la contraseña',
                        'respond' => $affected,
                    ]);
                }
            }
        }