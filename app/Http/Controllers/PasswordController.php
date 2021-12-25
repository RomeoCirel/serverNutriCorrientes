<?php

namespace App\Http\Controllers;

use App\Auxiliares\MensajeError;
use App\Auxiliares\MensajeExito;
use App\Auxiliares\Respuesta;
use App\Http\Requests\Usuarios\ModificarClaveRequest;
use App\Http\Requests\Usuarios\ResetPasswordRequest;
use App\Mail\RecuperarClave;
use App\Models\Usuario;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Throwable;

class PasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|void
     * @throws Exception
     */
    public function recuperar(ResetPasswordRequest $request)
    {
        $dni = $request->input('dni');
        $asuntoMail = "Recuperación de clave";

        $error = "Ha ocurrido un error mientras se intentaba generar una nueva contraseña, \n por favor vuelva a intententar o contactese con el administrador";
        try {
            $usuario = Usuario::where('dni', $dni)->firstOrFail();

            $password = $this->generarCadenaAleatoria();
            $usuario->password = Hash::make($password);
            $usuario->cambiar_clave = true;
            $cuerpoMail = [
                'nombre' => $usuario->nombre,
                'apellido' => $usuario->apellido,
                'dni' => $usuario->dni,
                'clave' => $password
            ];
            
            if ($usuario->save()) {
                $usuario->tokens()->delete();
                $correo = $usuario->email;
                $exito = "Se le ha enviado una nueva contraseña al siguiente E-Mail: $correo";
                Mail::to($correo)->queue(new RecuperarClave($cuerpoMail, $asuntoMail));
                $mensajeExito = new MensajeExito($exito, 'RECUPERADA');

                return Respuesta::exito([], $mensajeExito, 200);
            }
        } catch (Throwable $th) {
            $mensajeError = new MensajeError($error, 'NO_RECUPERADA');
            return Respuesta::error($mensajeError, 500);
        }
    }

    public function generarCadenaAleatoria($largo = 8): string
    {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $totalCaracteres = strlen($caracteres);
        $CadenaAleatoria = '';
        for ($i = 0; $i < $largo; $i++) {
            $CadenaAleatoria .= $caracteres[rand(0, $totalCaracteres - 1)];
        }
        return $CadenaAleatoria;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ModificarClaveRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function modificar(ModificarClaveRequest $request): JsonResponse
    {
        try {
            $nuevaClave = $request->input('password');
            $usuario = $request->user();
            $usuario->password = Hash::make($nuevaClave);
            $usuario->save();
            $authController = new AuthController;
            return $authController->logoutAllSessions($request);
        } catch (Exception $e) {
            $mensaje = new MensajeError('No pudimos Editar su contraseña, vuelva a intenar mas tarde', 'NO_MOSIDFICADO');
            return Respuesta::error($mensaje, 500);
        }
    }
}
