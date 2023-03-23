<?php

namespace App\Http\Requests\Students;

use Illuminate\Foundation\Http\FormRequest;

class StudentCreateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'dob' => 'required',
            'gender' => 'required|max:1',
            'address' => 'required',
            'phone_number' => 'numeric|max_digits:15',
            'nik' => 'unique:students,nik|required|numeric|max_digits:16',

            'father_name' => 'required',
            'father_dob' => 'required',
            'father_education' => 'nullable|max:50',
            'father_income' => 'nullable|numeric|max_digits:50',

            'mother_name' => 'required',
            'mother_dob' => 'required',
            'mother_income' => 'nullable|numeric|max_digits:50',
            'mother_education' => 'nullable|max:50',
            
            'guardian_name' => 'nullable',
            'guardian_dob' => 'nullable',
            'guardian_income' => 'nullable|numeric|max_digits:50',
            'guardian_education' => 'nullable|max:50',
        ];
    }
}
