<?php

namespace App\Http\Requests;

use AppException\EmployeeNotFoundException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
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

    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
            'role' => ['required', 'in:leader,staff']
        ];
    }
    public function messages()
    {
        return [
            'email.required' => 'Email cannot be empty',
            'email.email' => 'Email format is invalid',
            'password.required' => 'Password cannot be empty',
            'password.string' => 'Password must be a string',
            'password.min' => 'Password minimum 6 characters',
            'role.required' => 'Role is required',
            'role.in' => 'Role must be leader or staff',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(EmployeeNotFoundException::sendValidationError($validator->errors()->toArray()));
    }
}
