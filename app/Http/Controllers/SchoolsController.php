<?php

namespace App\Http\Controllers;

use App\Http\Requests\SchoolRequest;
use App\Models\School;
use App\Models\Staff;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SchoolsController extends Controller
{
    protected $title = "Sekolah";
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = $this->title;
        return view('pages.school.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Tambah Sekolah";
        $schools = School::induk()->get();
        $grade_school =  School::GRADE_SCHOOL;
        return view('pages.school.create', compact('schools', 'title', 'grade_school'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SchoolRequest $request)
    {

        $role = $request->has('school_id') ? User::ROLE_ADMIN_SEKOLAH : $role = User::ROLE_ADMIN_YAYASAN;

        DB::beginTransaction();
        try {
            // sekolah
            $school = new School();
            $school->school_name = $request->school_name;
            $school->school_id = $request->school_id;
            $school->province = $request->province;
            $school->city = $request->city;
            $school->postal_code = $request->postal_code;
            $school->address = $request->address;
            $school->grade = $request->grade;
            $school->email = $request->email;
            $school->phone = $request->phone;
            $school->save();

            // PIC
            $user = new User();
            $user->school_id = $school->getKey();
            $user->name = $request->name_pic;
            $user->email = $request->email_pic;
            $user->password = bcrypt($user->email);
            $user->save();


            // assign PIC
            $school->owner_id = $user->getKey();
            $school->save();

            // assign role
            $user->assignRole($role);

            DB::commit();
        } catch (Exception $th) {
            Log::error($th->getMessage(), [
                'action' => 'Tambah sekolah',
                'user' => auth()->user()->name,
                'sekolah' => $school->name
            ]);
            DB::rollback();
            return redirect()->route('schools.create')->withToastError('Ups, terjadi kesalahan saat menambah data!');
        }

        return redirect()->route('schools.index')->withToastSuccess('Berhasil menambah data!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(School $school)
    {

        $school->load('owner');
        $schools = School::induk()->whereNotIn('id', [$school->getKey()])->get();
        $title = "Ubah Sekolah";
        $grade_school =  School::GRADE_SCHOOL;
        return view('pages.school.edit', compact('schools', 'school', 'title', 'grade_school'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SchoolRequest $request, School $school)
    {
        $role = $request->has('school_id') ? User::ROLE_ADMIN_SEKOLAH : $role = User::ROLE_ADMIN_YAYASAN;

        DB::beginTransaction();
        try {
            $school->school_name = $request->school_name;
            $school->school_id = $request->school_id;
            $school->province = $request->province;
            $school->city = $request->city;
            $school->postal_code = $request->postal_code;
            $school->address = $request->address;
            $school->grade = $request->grade;
            $school->email = $request->email;
            $school->phone = $request->phone;
            $school->save();

            DB::commit();
        } catch (Exception $th) {
            Log::error($th->getMessage(), [
                'action' => 'Ubah sekolah',
                'user' => auth()->user()->name,
                'school' => $school->name
            ]);
            DB::rollback();
            return redirect()->route('schools.index')->withToastError('Ups, terjadi kesalahan saat mengubah data!');
        }

        return redirect()->route('schools.index')->withToastSuccess('Berhasil mengubah data!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(School $school)
    {
        DB::beginTransaction();
        try {
            $school->delete();
            DB::commit();
            return response()->json([
                'msg' => 'Berhasil menghapus data sekolah!'
            ], 200);
        } catch (Exception $th) {
            Log::error($th->getMessage(), [
                'action' => 'Hapus sekolah',
                'user' => auth()->user()->name,
                'sekolah' => $school->name
            ]);
            DB::rollback();
            return response()->json([
                'msg' => 'Ups gagal menghapus data sekolah!'
            ], 400);
        }
    }
}
