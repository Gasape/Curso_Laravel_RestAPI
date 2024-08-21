<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class putRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    function failedValidation(Validator $validator)
    {
        if($this->expectsJson()){
            $response = new Response($validator->errors(),422);
            throw new ValidationException($validator, $response);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user');
        return[
            'name' => 'string',
            'email' => 'email|unique:users,email, ' . $userId,
            'password' => 'min:6',
            'verified' => 'in:' . User::Usuario_Verificado . ',' . User::Usuario_No_Verificado,
            'admin' => 'in:' . User::Usuario_Administrador . ',' . User::Usuario_Regular,
        ];
    }
}
