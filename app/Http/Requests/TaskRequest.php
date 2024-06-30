<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TaskRequest extends FormRequest
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
            'status' => [
                'required'
            ],
            'title' => [
                'max:500',
                'required'
            ],
            'due_date' => [
                'required'
            ],
            'description' => [
                'max:2000',
                'required'
            ],
            'status' => [
                'required',
                'in:' . implode(',', Task::getStatusValues())
            ]
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
