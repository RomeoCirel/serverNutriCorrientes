<?php

namespace App\Http\Requests\Usuarios;

use App\Http\Requests\Usuarios\UsuariosRequest;

class LoginRequest extends UsuariosRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $this->dni();
        $this->password();
        $this->dispositivo();
        return $this->reglas;
    }
}