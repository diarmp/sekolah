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
            'period'      => [
                'required',
                Rule::unique('tuitions')->where(function ($q) {
                    $q->where('period', $this->period);
                    $q->where('price', $this->name);
                    $q->where('school_id', $this->school_id);
                    $q->where('tuition_type_id', $this->tuition_type_id);
                    $q->where('academic_year_id', $this->academic_year_id);
                    $q->where('grade_id', $this->grade_id);
                })
            ],
            'price' => 'required|numeric|gt:0'
        ];
    }

    public function putMethod(): array
    {

        return [
            'tuition_type_id' => 'required|exists:tuition_types,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'grade_id' => 'required|exists:grades,id',
            'period'      => [
                'required',
                Rule::unique('tuitions')->where(function ($q) {
                    $q->where('period', $this->period);
                    $q->where('school_id', $this->school_id);
                    $q->where('tuition_type_id', $this->tuition_type_id);
                    $q->where('academic_year_id', $this->academic_year_id);
                    $q->where('grade_id', $this->grade_id);
                })->ignore($this->tuition->id)
            ],
            'price' => 'required|numeric|gt:0'
        ];
    }
}
