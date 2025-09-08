<?php
// EmployeeRequest.php
namespace AppRequest;

use AppException\EmployeeNotFoundException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EmployeeStoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:4', 'max:100'],
            'posisi' => ['required', 'string', 'min:3', 'max:100'],
            'department' => ['required', 'string', 'min:2', 'max:100'],
            'tugas' => ['nullable', 'string'],
            'gaji' => ['required', 'numeric'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'name cannot be empty',
            'name.string' => 'name must be a string',
            'name.min' => 'minimum characters is 4',
            'name.max' => 'maximum characters is 100',
            'posisi.required' => 'position cannot be empty',
            'posisi.string' => 'position must be a string',
            'posisi.min' => 'minimum characters is 3',
            'posisi.max' => 'maximum characters is 100',
            'department.required' => 'department cannot be empty',
            'department.string' => 'department must be a string',
            'department.min' => 'minimum characters is 2',
            'department.max' => 'maximum characters is 100',
            'tugas.string' => 'assignment must be a string',
            'gaji.required' => 'salary cannot be empty',
            'gaji.numeric' => 'salary must be a number',
        ];
    }
    protected function failedValidation(Validator $validator){
        throw new HttpResponseException(EmployeeNotFoundException::sendValidationError($validator->errors()->toArray()));
    }
}
