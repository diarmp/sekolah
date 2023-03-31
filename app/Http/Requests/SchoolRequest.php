<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SchoolRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'grade' => [
                'required',
                Rule::notIn(["-"]),
            ],
            'address' => 'required|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'phone' => 'required|numeric',
            'email' => 'required|email|max:255',
            'owner' => [
                'required',
                'numeric',
                Rule::notIn(["-"]),
            ],
            'pic_name' => 'required|string|max:100',
            'pic_email' => 'required|string|max:100',
        ];
    }

    protected function putMethod(): array
    {
        return [
            'name' => 'required|string|max:255',
            'grade' => [
                'required',
                Rule::notIn(["-"]),
            ],
            'address' => 'required|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'phone' => 'required|numeric',
            'email' => 'required|email|max:255',
            'owner' => [
                'required',
                'numeric',
                Rule::notIn(["-"]),
            ],
        ];
    }
}
