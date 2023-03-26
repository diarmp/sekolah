<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'school_id' => 'nullable|exists:schools,id',
            'name' => 'required|string|max:30',
            'pic_name' => 'required|string|max:100',
            'pic_email' => 'required|string|max:100',
        ];
    }

    protected function putMethod(): array
    {
        return [
            'school_id' => 'nullable|exists:schools,id',
            'name' => 'required|string|max:30',
        ];
    }
}
