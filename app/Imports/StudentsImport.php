<?php

namespace App\Imports;

use App\Models\Student;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentsImport implements ToCollection, WithHeadingRow, WithValidation
{
    private $school_id;
    private $academic_year;

    public function __construct(string $school_id, string $academic_year)
    {
        $this->school_id = $school_id;
        $this->$academic_year = $academic_year;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {

        dd($collection);
        Validator::make($collection->toArray(), )->validate();

        try {
            DB::beginTransaction();

            foreach ($collection as $key => $item) {
                // Save Student
                    $student                            = new Student;
                    $student->school_id                 = $this->school_id;
                    $student->academic_year_id          = $this->academic_year;
    
                    $student->name                      = $item['nama'];
                    $student->gender                    = $item['jenis_kelamin'];
                    $student->address                   = $item['alamat'];
                    $student->dob                       = $item['tanggal_lahir'];
                    $student->religion                  = $item['agama'];
                    $student->phone_number              = $item['no_telepon'];
                    $student->nik                       = $item['nik'];
                    $student->nis                       = $item['nis'];
                    $student->nisn                      = $item['nisn'];
    
                    $student->father_name               = $item['nama_ayah'];
                    $student->father_dob                = $item['tanggal_lahir_ayah'];
                    $student->father_work               = $item['pekerjaan_ayah'];
                    $student->father_education          = $item['edukasi_terakhir_ayah'];
                    $student->father_income             = $item['pendapatan_ayah'];
    
                    $student->mother_name               = $item['nama_ibu'];
                    $student->mother_dob                = $item['tanggal_lahir_ibu'];
                    $student->mother_work               = $item['pekerjaan_ibu'];
                    $student->mother_education          = $item['edukasi_terakhir_ibu'];
                    $student->mother_income             = $item['pendapatan_ibu'];
    
                    $student->guardian_name             = $item['nama_wali'];
                    $student->guardian_dob              = $item['tanggal_lahir_wali'];
                    $student->guardian_work             = $item['pekerjaan_wali'];
                    $student->guardian_education        = $item['edukasi_terakhir_wali'];
                    $student->guardian_income           = $item['pendapatan_wali'];
    
                    $student->save();
                // End Save Student
            }
            DB::commit();
            return redirect()->route('students.index')->withToastSuccess('Berhasil mengimpor data murid!');
            
        } catch (ValidationException $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->withToastError($th->getMessage());
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->withToastError('Ops, ada kesalahan saat mengimpor data murid!');
        }

    }

    public function rules(): array
    {
        return [
            'nama' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required|max:1',
            'alamat' => 'required',
            'agama' => 'required',
            'no_telepon' => 'nullable|max:15',
            'nik' => 'required|numeric|max_digits:16',
            'nis' => 'nullable|numeric|max_digits:20',
            'nisn' => 'nullable|numeric|max_digits:10',

            'nama_ayah' => 'required',
            'tanggal_lahir_ayah' => 'required',
            'edukasi_terakhir_ayah' => 'nullable|max:50',
            'pendapatan_ayah' => 'nullable|numeric|max_digits:50',

            'nama_ibu' => 'required',
            'tanggal_lahir_ibu' => 'required',
            'pendapatan_ibu' => 'nullable|numeric|max_digits:50',
            'edukasi_terakhir_ibu' => 'nullable|max:50',

            'nama_wali' => 'nullable',
            'tanggal_lahir_wali' => 'nullable',
            'pendapatan_wali' => 'nullable|numeric|max_digits:50',
            'edukasi_terakhir_wali' => 'nullable|max:50',
        ];
    }
}
