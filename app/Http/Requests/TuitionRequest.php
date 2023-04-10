<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TuitionRequest extends FormRequest
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

    public function postMethod(): array
    {
        return [
            'tuition_type_id' => 'required|exists:tuition_types,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'grade_id' => 'required|exists:grades,id',
            'price' => 'required|numeric|gt:0',
            'requested_by' => 'required|exists:users,id',
            'approved_by' => 'required|exists:users,id',
        ];
    }

    public function putMethod(): array
    {

        return [
            'tuition_type_id' => 'required|exists:tuition_types,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'grade_id' => 'required|exists:grades,id',
            'price' => 'required|numeric|gt:0',
            'requested_by' => 'required|exists:users,id',
            'approved_by' => 'required|exists:users,id',
        ];
    }
}
