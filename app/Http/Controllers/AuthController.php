<?php

namespace App\Http\Controllers;

use App\Auxiliares\MensajeError;
use App\Auxiliares\MensajeExito;
use App\Auxiliares\Respuesta;
use App\Models\Usuario;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Usuarios\LoginRequest;

class AuthController extends Controller
{
    /**
     * Autenticar Usuario.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $dni = $request->dni;
        $pass = $request->password;
        $device = $request->device_name;

        $user = Usuario::where('dni', $dni)->first();

        if (!$user || !Hash::check($pass, $user->password)) {
            $mensaje = new MensajeError('Credenciales Invalidas', 'CREDENCIALES_INVALIDAS');
            return Respuesta::error($mensaje, 500);
        }
        $tokenText = "$dni - $device";
        return $this->setRespuestaToken($user, $tokenText);
    }

    /**
     * Cerrar Session.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        $mensaje = new MensajeExito('Sesion Finalizada', 'LOGOUT');
        return Respuesta::exito(['sinDatos' => null], $mensaje, 200);
    }

    /**
     * Cerrar todas las sesiones del usuario.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function logoutAllSessions(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();
        $mensaje = new MensajeExito('Todas sus Sesiones han sido Finalizadas', 'LOGOUT');
        return Respuesta::exito(['sinDatos' => null], $mensaje, 200);
    }

    /**
     * Obtener Usuario Autenticado.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function usuario(Request $request): JsonResponse
    {
        $usuario = $request->user();
        $usuario->genero;
        return Respuesta::exito(['usuario' => $usuario], null, 200);
    }

    /**
     * Formateo del JSON que devuelve el token
     *
     * @param Usuario $user
     * @param String $tokenText
     * @return JsonResponse
     * @throws Exception
     */
    protected function setRespuestaToken(Usuario $user, string $tokenText): JsonResponse
    {
        $usuario = $user;

        $fechaActual = Carbon::now();

        $autenticacion = [
            'usuario' => $usuario,
            'token' => $usuario->createToken($tokenText)->plainTextToken,
            'sesionIniciada' => $fechaActual->toIso8601String()
        ];

        return Respuesta::exito(['autenticacion' => $autenticacion], null, 200);
    }


}
