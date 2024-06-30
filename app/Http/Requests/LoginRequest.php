<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'password' => 'required|string',
            'email' => 'required|string|email'
        ];
    }

    /**
     *
     */
    protected function failedValidation(Validator $validator)
    {
        $errors['estado'] = 'error';
        $errors['mensaje'] = 'Existen errores de validación';
        if ($validator instanceof Validator) {
            $errors['validaciones'] = $validator->errors()->all();
            $errors['data'] = $validator->getData();
        } else {
            $errors['validaciones'] = $validator;
        }
        $errors['statusCode'] = 422;
        throw new HttpResponseException(response()->json($errors, 422));
    }
}
