<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Config;

class SchoolConfigRequest extends FormRequest
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
            'POST' => $this->postMethod()
        };
    }

    public function messages(): array
    {
    foreach($this->get('config') as $key=>$val){
        $name = config::where('code',$key)->first();
        $message['config.'.$key.'.required'] = $name->name." is required";
    }
        return $message;
    }

    public function postMethod(): array
    {
        return [
            'config.*'      => 'required'
        ];
    }

    // public function putMethod(): array
    // {

    //     return [
    //         'code' => 'required',
    //         'name'      =>'required'
    //     ];
    // }
}
