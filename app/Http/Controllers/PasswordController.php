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
            $usuario->cambiar_clave = 1;
            $cuerpoMail = [
                'nombre' => $usuario->nombre,
                'apellido' => $usuario->apellido,
                'dni' => $usuario->dni,
                'clave' => $password
            ];
            if ($usuario->save()) {
                $exito = "Se le ha enviado una nueva contraseña al siguiente E-Mail";
                Mail::to($usuario->email)->queue(new RecuperarClave($cuerpoMail, $asuntoMail));
                $mensajeExito = new MensajeExito($exito, 'RECUPERADA');
                return Respuesta::exito(['usuario' => $usuario], $mensajeExito, 200);
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
     * @return Response
     */
    public function modificar(ModificarClaveRequest $request): Response
    {
        //
    }
}
