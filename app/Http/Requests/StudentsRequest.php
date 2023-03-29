<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentsRequest extends FormRequest
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
        return match ($this->method()) {
            'POST' => $this->postMethod(),
            'PUT'  => $this->putMethod()
        };
    }

    protected function postMethod(): array
    {
        return [
            'academic_year_id' => 'required|exists:academic_years,id',

            'name' => 'required',
            'email' => 'nullable|email',
            'dob' => 'required',
            'religion' => 'required',
            'gender' => 'required|max:1',
            'address' => 'required',
            'phone_number' => 'nullable|max:15',
            'nik' => 'required|numeric|max_digits:16',
            'nis' => 'nullable|numeric|max_digits:20',
            'nisn' => 'nullable|numeric|max_digits:10',
            

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

            'tuitions' => 'nullable|array',
            'tuitions.*' => "nullable|numeric",
        ];
    }

    protected function putMethod(): array
    {
        return [
            'academic_year_id' => 'required|exists:academic_years,id',

            'name' => 'required',
            'email' => 'nullable|email',
            'dob' => 'required',
            'gender' => 'required|max:1',
            'address' => 'required',
            'religion' => 'required',
            'phone_number' => 'nullable|max:15',
            'nik' => 'required|numeric|max_digits:16',
            'nis' => 'nullable|numeric|max_digits:20',
            'nisn' => 'nullable|numeric|max_digits:10',

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

            'selected_tuitions' => 'nullable|array',
            'selected_tuitions.*' => "nullable|numeric",
            'tuitions' => 'nullable|array',
            'tuitions.*' => "nullable|numeric",
        ];
    }
}
