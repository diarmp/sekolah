<?php

namespace App\Http\Requests;

use App\Models\Classroom;
use App\Models\ClassroomStudent;
use App\Models\Student;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;


class AssignClassroomStudentRequest extends FormRequest
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
        session(['classroom_id' => $this->classroom_id]);
        return match ($this->method()) {
            'POST' => $this->postMethod(),
            'DELETE'  => $this->deleteMethod()
        };
    }

    public function postMethod(): array
    {
        return [
            'classroom_id' => 'required',
            'id'           => 'required|array',
            'id.*'         => Rule::forEach(function () {
                return [
                    function ($attribute, $student_id, $fail) {
                        $classroom = Classroom::whereHas('students', fn ($q) => $q->where('student_id', $student_id))->find($this->classroom_id);
                        if ($classroom) {
                            $student = Student::find($student_id);

                            return $fail("{$student->nis}({$student->name}) ");
                        }
                        return true;
                    },
                ];
            })
        ];
    }



    public function deleteMethod(): array
    {
        return [
            'classroom_id' => 'required',
            'id'           => 'required|array'
        ];
    }


    public function messages()
    {
        return [
            'classroom_id.required' => "Kelas Wajib Dipilih",
            'id.required' => 'Harap Pilih Siswa Yang Ingin Didata',
        ];
    }
}
