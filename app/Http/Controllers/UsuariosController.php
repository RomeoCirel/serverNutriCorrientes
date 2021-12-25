<?php

namespace App\Http\Controllers;

use App\Auxiliares\MensajeError;
use App\Auxiliares\MensajeExito;
use App\Auxiliares\Respuesta;
use App\Http\Requests\Usuarios\CrearUsuariosRequest;
use App\Http\Requests\Usuarios\ModificarUsuarioRequest;
use App\Mail\RegistroUsuarioMail;
use App\Models\Usuario;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Mail;

class UsuariosController extends Controller
{
    /**
     * @var string
     */
    private $generoModelo;
    /**
     * @var string
     */
    private $modeloSingular;
    /**
     * @var string
     */
    private $modeloPlural;
    /**
     * @var BaseController
     */
    private $controladorBase;

    public function __construct()
    {
        $this->generoModelo = 'masculino';
        $this->modeloSingular = 'usuario';
        $this->modeloPlural = 'usuarios';
        $this->controladorBase = new BaseController($this->modeloSingular, $this->modeloPlural, $this->generoModelo);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request): JsonResponse
    {
        $parametros = [
            'modelo' => 'Usuario',
            'campos' => [
                'id',
                'nombre',
                'apellido',
                'dni',
                'email',
                'fechaNacimiento',
                'genero_id',
                'cambiar_clave',
                'created_at',
                'updated_at',
                'deleted_at',
            ],
            'relaciones' => null,
            'buscar' => $request->input("buscar", null),
            'eliminados' => $request->input("eliminados", false),
            'paginado' => [
                'porPagina' => $request->input("porPagina", 10),
                'ordenarPor' => $request->input("ordenarPor", 'apellido'),
                'orden' => $request->input("orden", 'ASC'),
            ]
        ];

        return $this->controladorBase->index($parametros, 'los usuarios');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CrearUsuariosRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function store(CrearUsuariosRequest $request): JsonResponse
    {
        $nombre = $request->input('nombre', 'el usuario');
        try {
            $inputs = $request->only('nombre', 'apellido', 'dni', 'email', 'fechaNacimiento', 'genero_id');
            $PasswordController = new PasswordController();
            $clave = $PasswordController->generarCadenaAleatoria(8);
            $inputs['password'] = bcrypt($clave);
            $usuario = new Usuario;
            $usuario->fill($inputs);
            $usuario->save();

            $asuntoMail = "Recuperación de clave";
            $cuerpoMail = [
                'nombre' => $usuario->nombre,
                'apellido' => $usuario->apellido,
                'dni' => $usuario->dni,
                'clave' => $clave
            ];
            Mail::to($usuario->email)->queue(new RegistroUsuarioMail($cuerpoMail, $asuntoMail));

            $usuarioGuardado = Usuario::findOrFail($usuario->id);
            $usuarioGuardado->genero;

            $mensaje = new MensajeExito;
            $mensaje->guardar($nombre, $this->generoModelo);

            return Respuesta::exito(['usuario' => $usuarioGuardado], $mensaje, 201);
        } catch (Exception $e) {
            $mensaje = new MensajeError;
            $mensaje->guardar($nombre, $this->generoModelo);
            return Respuesta::error($mensaje, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Usuario $usuario
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Usuario $usuario): JsonResponse
    {
        try {
            $usuario->genero;
            return Respuesta::exito(['usuario' => $usuario]);
        } catch (Exception $e) {
            $mensaje = new MensajeError();
            $mensaje->obtener('del usuario');
            return Respuesta::error($mensaje, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ModificarUsuarioRequest $request
     * @param Usuario $usuario
     * @return JsonResponse
     * @throws Exception
     */
    public function update(ModificarUsuarioRequest $request, Usuario $usuario): JsonResponse
    {
        $nombre = $request->input('nombre');
        try {
            $inputs = $request->only('nombre', 'apellido', 'dni', 'email', 'fechaNacimiento', 'genero_id');
            $usuario->fill($inputs);
            $usuario->save();

            $usuarioGuardado = Usuario::findOrFail($usuario->id);

            $mensaje = new MensajeExito;
            $mensaje->actualizar($nombre, $this->generoModelo);

            return Respuesta::exito(['usuario' => $usuarioGuardado], $mensaje, 201);
        } catch (Exception $e) {
            $mensaje = new MensajeError;
            $mensaje->actualizar($usuario->nombre, $this->generoModelo);
            return Respuesta::error($mensaje, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Usuario $usuario
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Usuario $usuario): JsonResponse
    {
        try {
            $usuario->delete();
            return Respuesta::exito(['usuario' => $usuario]);
        } catch (Exception $e) {
            $mensaje = new MensajeError;
            $mensaje->eliminar($usuario->nombre, $this->generoModelo);
            return Respuesta::error($mensaje, 500);
        }
    }

    /**
     *  Restaurar la instancia que ha sido eliminada
     *
     * @param Usuario $usuario
     * @return JsonResponse
     * @throws Exception
     */
    public function restore(Usuario $usuario): JsonResponse
    {
        try {
            $usuario->restore();
            $mensajeExito = new MensajeExito();
            $mensajeExito->restaurar($usuario->nombre, $this->generoModelo);

            return Respuesta::exito([$this->modeloSingular => $usuario], $mensajeExito, 200);
        } catch (\Throwable $th) {
            $mensajeError = new MensajeError();
            $mensajeError->restaurar($usuario->nombre, $this->generoModelo);

            return Respuesta::error($mensajeError, 500);
        }
    }
}
