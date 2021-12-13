<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Convert a validation exception into a JSON response.
     *
     * @param  Request  $request
     * @param ValidationException $exception
     * @return JsonResponse
     */
    protected function invalidJson($request, ValidationException $exception): JsonResponse
    {
        $reglas = $exception->validator->getRules();
        foreach ($reglas as $campo => $validaciones) {
            $errores[$campo] = [
                'esValido' => true,
                'error' => null
            ];
        }

        $erroresValidacion = $exception->errors();
        foreach ($erroresValidacion as $campo => $mensaje) {
            $errores[$campo] = [
                'esValido' => is_null($mensaje[0]),
                'error' => $mensaje[0]
            ];
        }

        return new JsonResponse(['errores' => $errores], $exception->status);
    }
}
