<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class StudentsImport implements ToCollection, WithHeadingRow
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
    public function collection(Collection $row)
    {
        Validator::make($row->toArray(), [
            'Nama' => 'required',
            'Tanggal_Lahir' => 'required',
            'Jenis_Kelamin' => 'required|max:1',
            'Alamat' => 'required',
            'Agama' => 'required',
            'No_Telepon' => 'nullable|max:15',
            'NIK' => 'required|numeric|max_digits:16',
            'NIS' => 'nullable|numeric|max_digits:20',
            'NISN' => 'nullable|numeric|max_digits:10',

            'Nama_Ayah' => 'required',
            'Tanggal_Lahir_Ayah' => 'required',
            'Edukasi_Terakhir_Ayah' => 'nullable|max:50',
            'Pendapatan_Ayah' => 'nullable|numeric|max_digits:50',

            'Nama_Ibu' => 'required',
            'Tanggal_Lahir_Ibu' => 'required',
            'Pendapatan_Ibu' => 'nullable|numeric|max_digits:50',
            'Edukasi_Terakhir_Ibu' => 'nullable|max:50',

            'Nama_Wali' => 'nullable',
            'Tanggal_Lahir_Wali' => 'nullable',
            'Pendapatan_Wali' => 'nullable|numeric|max_digits:50',
            'Edukasi_Terakhir_Wali' => 'nullable|max:50',
        ])->validate();


        try {
            
            DB::beginTransaction();
    
                // Save Student
                    $student                            = new Student;
                    $student->school_id                 = $this->school_id;
                    $student->academic_year_id          = $this->academic_year;
    
                    $student->name                      = $row['Nama'];
                    $student->gender                    = $row['Jenis_Kelamin'];
                    $student->address                   = $row['Alamat'];
                    $student->dob                       = $row['Tanggal_Lahir'];
                    $student->religion                  = $row['Agama'];
                    $student->phone_number              = $row['No_Telepon'];
                    $student->nik                       = $row['NIK'];
                    $student->nis                       = $row['NIS'];
                    $student->nisn                      = $row['NISN'];
                    $student->father_name               = $row['Nama_Ayah'];
                    $student->father_dob                = $row['Tanggal_Lahir_Ayah'];
                    $student->father_work               = $row['Pekerjaan_Ayah'];
                    $student->father_education          = $row['Edukasi_Terakhir_Ayah'];
                    $student->father_income             = $row['Pendapatan_Ayah'];
                    $student->mother_name               = $row['Nama_Ibu'];
                    $student->mother_dob                = $row['Tanggal_Lahir_Ibu'];
                    $student->mother_work               = $row['Pekerjaan_Ibu'];
                    $student->mother_education          = $row['Edukasi_Terakhir_Ibu'];
                    $student->mother_income             = $row['Pendapatan_Ibu'];
                    $student->guardian_name             = $row['Nama_Wali'];
                    $student->guardian_dob              = $row['Tanggal_Lahir_Wali'];
                    $student->guardian_work             = $row['Pekerjaan_Wali'];
                    $student->guardian_education        = $row['Edukasi_Terakhir_Wali'];
                    $student->guardian_income           = $row['Pendapatan_Wali'];
    
                    $student->save();
                // End Save Student
    
            DB::commit();

        } catch (ValidationException $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->withToastError($th->getMessage());
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->withToastError('Ops, ada kesalahan saat mengimpor data murid!');
        }

    }
}
