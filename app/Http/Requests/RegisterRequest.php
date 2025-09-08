<?php

namespace App\Http\Requests;

use AppException\EmployeeNotFoundException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Hash;

class RegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Name cannot be empty',
            'email.required' => 'Email cannot be empty',
            'email.email' => 'Email format is invalid',
            'password.required' => 'Password cannot be empty',
            'password.string' => 'Password must be a string',
            'password.min' => 'Password minimum 6 characters',
            'password.confirmed' => 'Password confirmation does not match',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(EmployeeNotFoundException::sendValidationError($validator->errors()->toArray()));
    }

    public function validated($key = null, $default = null){
        $validatedData = parent::validated();
        $validatedData['password'] = Hash::make($validatedData['password']);
        return $validatedData;
    }

}
