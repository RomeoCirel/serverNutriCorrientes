<?php

namespace App\Http\Requests\Usuarios;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\PasswordActual;

class UsuariosRequest extends FormRequest
{
    protected $reglas = [];

    public function nombre()
    {
        $this->reglas ['nombre'] = ['bail', 'required', 'string', 'min:3', 'max:70'];
    }

    public function apellido()
    {
        $this->reglas['apellido'] = ['bail', 'required', 'string', 'min:3', 'max:70'];
    }

    public function dni()
    {
        $this->reglas['dni'] = ['bail', 'integer', 'digits:8'];
    }

    public function dniUnico()
    {
        $this->reglas['dni'] = ['bail', 'integer', 'digits:8', 'unique:usuarios,dni'];
    }

    public function ignoreDni()
    {
        $usuario = $this->usuario;
        $this->reglas['dni'][3] .= ',' . $usuario->id . ',id';
    }

    public function email()
    {
        $this->reglas['email'] = ['bail', 'required', 'email', 'max:150'];
    }

    public function uniqueEmail()
    {
        $this->reglas['email'] = ['bail', 'required', 'email', 'max:150', 'unique:usuarios,email'];
    }

    public function ignoreEmail()
    {
        $this->reglas['email'] = ['bail', 'required', 'email', 'max:150', Rule::unique('usuarios')->ignore($this->usuario->id)];
    }

    public function fechaNacimiento()
    {
        $this->reglas['fechaNacimiento'] = ['bail', 'required', 'date', 'max:10'];
    }

    public function password()
    {
        $this->reglas['password'] = ['bail', 'required', 'string', 'min:8'];
    }

    public function passwordActual()
    {
        $this->reglas['passwordActual'] = ['bail', 'required', new PasswordActual];
    }

    public function passwordComfirm()
    {
        $this->reglas['password'] = ['bail', 'required', 'string', 'min:8', 'confirmed'];
    }

    public function genero()
    {
        $this->reglas['genero_id'] = ['bail', 'required', 'integer', 'exists:App\Models\Genero,id'];
    }

    public function dispositivo()
    {
        $this->reglas['device_name'] = ['bail', 'required', 'string', 'min:4', 'max:30'];
    }

    public function messages(): array
    {
        return [
            'genero_id.required' => 'Debe Seleccionar un genero',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool<
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
        return [
            //
        ];
    }
}
