<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GradeRequest extends FormRequest
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
            'name'      => [
                'required',
                "max:5",
                Rule::unique('grades')->where(function ($q) {
                    $q->where('name', $this->name);
                    $q->where('school_id',$this->school_id);
                })
            ]
        ];
    }

    public function putMethod(): array
    {

        return [
            'name'      => [
                'required',
                "max:5",
                Rule::unique('grades')->where(function ($q) {
                    $q->where('name', $this->name);
                    $q->where('school_id',$this->school_id);
                })->ignore($this->grade->id)
            ]
        ];
    }
}
