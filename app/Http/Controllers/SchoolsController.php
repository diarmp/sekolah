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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Sekolah";
        return view('pages.school.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Tambah Sekolah";
        $schools = School::induk()->get();
        return view('pages.school.create', compact('schools', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SchoolRequest $request)
    {
        $type = School::TYPE_SEKOLAH;
        $school_id = $request->school_id;
        $role = User::ROLE_ADMIN_SEKOLAH;
        if ($request->school_id == "") {
            $type = School::TYPE_YAYASAN;
            $school_id = null;
            $role = User::ROLE_ADMIN_YAYASAN;
        }

        DB::beginTransaction();
        try {
            // sekolah
            $school = new School();
            $school->name = $request->name;
            $school->school_id = $school_id;
            $school->type = $type;
            $school->save();

            // PIC
            $user = new User();
            $user->school_id = $school->getKey();
            $user->name = $request->pic_name;
            $user->email = $request->pic_email;
            $user->password = bcrypt($user->email);
            $user->save();


            // Staff
            $staff = new Staff();
            $staff->school_id = $school->getKey();
            $staff->user_id = $user->getKey();
            $staff->name = $user->name;
            $staff->save();

            // assign PIC
            $school->staff_id = $staff->getKey();
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
            return redirect()->route('schools.index')->withToastError('Ups, terjadi kesalahan saat menambah data!');
        }

        return redirect()->route('schools.index')->withToastSuccess('Berhasil menambah data!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(School $school)
    {
        $schools = School::whereNotIn('id', [$school->getKey()])->get();
        $title = "Ubah Sekolah";
        return view('pages.school.edit', compact('schools', 'school', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SchoolRequest $request, School $school)
    {
        $type = School::TYPE_SEKOLAH;
        $school_id = $request->school_id;
        if ($request->school_id == "") {
            $type = School::TYPE_YAYASAN;
            $school_id = null;
        }

        DB::beginTransaction();
        try {
            $school->name = $request->name;
            $school->school_id = $school_id;
            $school->type = $type;
            $school->staff_id = $request->user_id;
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
