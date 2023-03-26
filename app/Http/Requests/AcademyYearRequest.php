<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AcademyYearRequest extends FormRequest
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
            'school_id' => 'required|exists:schools,id',
            'name'      => [
                'required',
                Rule::unique('academic_years')->where(function ($q) {
                    $q->where('name', $this->name);
                    $q->where('school_id', $this->school_id);
                })
            ]
        ];
    }

    public function putMethod(): array
    {

        return [
            'school_id' => 'required|exists:schools,id',
            'name'      => [
                'required',
                Rule::unique('academic_years')->where(function ($q) {
                    $q->where('name', $this->name);
                    $q->where('school_id', $this->school_id);
                })->ignore($this->academy_year->id)
            ]
        ];
    }
}
