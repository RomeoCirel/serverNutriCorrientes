<?php

namespace App\Http\Requests\Usuarios;


class RenovarTokenRequest extends UsuariosRequest
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
        $this->dispositivo();
        return $this->reglas;
    }
}
