<?php

namespace App\Http\Requests;

use App\Rules\AcademicYearRule;
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
            'school_id' => 'required',
            'name'      => [
                'required',
                Rule::unique('academic_years')->where(function ($q) {
                    $q->where('name', $this->name);
                    $q->where('school_id', session('school_id'));
                }),
                'years_formatted',
                'valid_year'
            ]
        ];
    }



    public function putMethod(): array
    {
        return [
            'school_id' => 'required',
            'name'      => [
                'required',
                Rule::unique('academic_years')->where(function ($q) {
                    $q->where('name', $this->name);
                    $q->where('school_id', session('school_id'));
                })->ignore($this->academy_year->id),
                'years_formatted',
                'valid_year'
            ]
        ];
    }


    public function withValidator($validator)
    {
        $validator->addExtension('years_formatted', function ($attribute, $value, $parameters, $validator) {
            return preg_match_all("/\b\d{4,4}\b/", $value) >= 2;
        });

        $validator->addExtension('valid_year', function ($attribute, $value, $parameters, $validator) {

            $years = preg_match_all("/\b\d{4,4}\b/", $value, $result);
            if (isset($result[0]) && count($result[0]) >= 2) {
                $startYear = $result[0][0];
                $endYear = $result[0][1];
                return $startYear < $endYear;
            }

            return true;
        });
    }

    public function messages()
    {
        return [
            'name.years_formatted' => 'The :attribute Invalid Formatted have xxxx - xxxx',
            'name.valid_year' => 'The :attribute Invalid Academy years Formatted',

        ];
    }
}
