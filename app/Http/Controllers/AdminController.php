<?php

namespace App\Http\Controllers;

use App\Imports\StudentsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\InternshipStudent;
use App\User;
use App\Role;
use App\GroupProject;
use Dotenv\Validator;
use App\Exports\InternshipStudentExport;
use App\Exports\LecturerExport;
use App\Exports\JobdescExport;
use Maatwebsite\Excel\Facades\Excel;

class adminController extends Controller
{
    public function showStudent()
    {
        return view('data.college_student');
    }

    public function show($id)
    {
        $collegeStudent = InternshipStudent::findOrFail($id);
        return response()->json(['data' => $collegeStudent]);
    }

    public function get()
    {
        $collegeStudents = InternshipStudent::with('User')->orderby('id', 'DESC')->get();
        return response()->json(['data' => $collegeStudents]);
    }

    public function save(Request $request)
    {
        $this->validate(
            $request,
            [
                'nim' => 'required|unique:internship_students,nim|max:13',
                'name' => 'required',
                'angkatan' => 'nullable|numeric|digits:4',
                'ipSemester' => 'nullable|numeric|min:0|max:4',
                'sksSemester' => 'nullable|numeric|digits_between:0,3',
                'ipk' => 'nullable|numeric|min:0|max:4',
                'sksTotal' => 'nullable|numeric|digits_between:0,3'
            ],
            [
                'required' => 'Harap di isi',
                'max' => 'Tidak boleh lebih dari :max',
                'min' => 'Jumlah karakter = :min',
                'numeric' => 'Hanya boleh di isi menggunakan angka',
                'digits' => 'Hanya bisa di isi dengan :digits karakter',
                'digits_between' => 'Jumlah karakter antara :min - :max',
                'unique' => 'NIM sudah digunakan'
            ]
        );

        $user = new User([
            'username' => $request->nim,
            'password' => $request->nim
        ]);
        $user->save();

        $user->roles()->sync(Role::whereRoleName('mahasiswa')->first()->id);

        $mahasiswa = new InternshipStudent;
        $mahasiswa->nim = $request->input('nim');
        $mahasiswa->name = $request->input('name');
        $mahasiswa->angkatan = $request->input('angkatan');
        $mahasiswa->gender = $request->input('gender');
        $mahasiswa->status = $request->input('status');
        $mahasiswa->ip_sem = $request->input('ipSemester');
        $mahasiswa->sks_sem = $request->input('sksSemester');
        $mahasiswa->ipk = $request->input('ipk');
        $mahasiswa->sks_total = $request->input('sksTotal');
        $mahasiswa->user_id = $user->id;

        if ($mahasiswa->save()) {
            return response()->json("success");
        }
        return response()->json("failed");
    }

    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'editname' => 'required',
                'editangkatan' => 'nullable|numeric|digits:4',
                'editipSemester' => 'nullable|numeric|min:0|max:4',
                'eidtsksSemester' => 'nullable|numeric|digits_between:0,3',
                'editipk' => 'nullable|numeric|min:0|max:4',
                'editsksTotal' => 'nullable|numeric|digits_between:0,3'
            ],
            [
                'required' => 'Harap di isi',
                'max' => 'Tidak boleh lebih dari :max',
                'min' => 'Jumlah karakter = :min',
                'numeric' => 'Hanya boleh di isi menggunakan angka',
                'digits' => 'Hanya bisa di isi dengan :digits karakter',
                'digits_between' => 'Jumlah karakter antara :min - :max',
            ]
        );
        
        $mahasiswa = InternshipStudent::findOrFail($id);
        $mahasiswa->nim = $request->input('editnim');
        $mahasiswa->name = $request->input('editname');
        $mahasiswa->angkatan = $request->input('editangkatan');
        $mahasiswa->gender = $request->input('editgender');
        $mahasiswa->status = $request->input('editstatus');
        $mahasiswa->ip_sem = $request->input('editipSemester');
        $mahasiswa->sks_sem = $request->input('editsksSemester');
        $mahasiswa->ipk = $request->input('editipk');
        $mahasiswa->sks_total = $request->input('editsksTotal');

        if ($mahasiswa->save()) {
            return response()->json("success");
        }
        return response()->json("failed");
    }

    public function showArsip()
    {
        return view('data.report');
    }

    public function arsipKoor()
    {
        $verified = GroupProject::with(['Agency', 'GroupProjectExaminer.Lecturer', 'GroupProjectSchedule', 'InternshipStudents' => function($abc) {
            $abc->with('User');
        }])->where('is_verified', '4')->get();
        return response()->json(['data' => $verified]);
    }
    public function arsipAdmin()
    {
        $verified = GroupProject::with(['Agency', 'GroupProjectExaminer.Lecturer', 'GroupProjectSchedule', 'InternshipStudents' => function($abc) {
            $abc->with('User');
        }])->where('is_verified', '>=', '4')->get();
        return response()->json(['data' => $verified]);
    }

    public function import(Request $request)
    {
        $collegeStudent = InternshipStudent::orderby('created_at', 'desc')->first();

        $numberOfBatch = 0;

        if (is_null($collegeStudent)) {
            $numberOfBatch = 1;
        } else {
            $numberOfBatch = $collegeStudent;
        }
        Excel::import(new StudentsImport($numberOfBatch), request()->file('select_file'));

        return back();
    }

    public function exportMhs()
    {
        return Excel::download(new InternshipStudentExport, 'MahasiswaPKL-PK.xlsx');
    }
    
    public function exportDosen()
    {
        return Excel::download(new LecturerExport, 'Data Dosen PKL-PK.xlsx');
    }

    public function exportJobdesc()
    {
        return Excel::download(new JobdescExport, 'Data Jobdesc PKL-PK.xlsx');
    }
}
