<?php

namespace App\Http\Controllers;

use App\Lecturer;
use Illuminate\Http\Request;
use App\Imports\LecturersImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LecturerController extends Controller
{
    public function showLecturer()
    {
        return view('data.lecturer');
    }

    public function show($id)
    {
        $lecturers = Lecturer::findOrFail($id);
        return response()->json(['data' => $lecturers]);
    }

    public function get()
    {
        $lecturers = Lecturer::orderby('id', 'DESC')->get();
        return response()->json(['data' => $lecturers]);
    }

    public function save(Request $request)
    {
        $this->validate(
            $request,
            [
                'NIP' => 'required|unique:lecturers,NIP|numeric',
                'name' => 'required',
                'NIDN' => 'nullable|numeric|unique:lecturers,NIDN'
            ],
            [
                'required' => 'Harap di isi',
                'unique'=>':attribute sudah ada',
                'numeric'=>'Hanya boleh menggunakan angka'
            ]
        );

        $lecturers = new Lecturer;
        $lecturers->NIP = $request->input('NIP');
        $lecturers->NIDN = $request->input('NIDN');
        $lecturers->name = $request->input('name');
        $lecturers->status = $request->input('status');

        if ($lecturers->save()) {
            return response()->json("success");
        }
        return response()->json("failed");
    }

    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'editNIP' => 'required|numeric|unique:lecturers,NIP,'.$id,
                'editname' => 'required',
                'editNIDN' => 'nullable|numeric|unique:lecturers,NIDN,'.$id,
            ],
            [
                'required' => 'Harap di isi',
                'unique'=>':attribute sudah ada',
                'numeric'=>'Hanya boleh menggunakan angka'
            ]
        );

        $lecturers = Lecturer::findOrFail($id);
        $lecturers->NIP = $request->input('editNIP');
        $lecturers->NIDN = $request->input('editNIDN');
        $lecturers->name = $request->input('editname');
        $lecturers->status = $request->input('editStatus');


        if ($lecturers->save()) {
            return response()->json("success");
        }
        return response()->json("failed");
    }

    public function import()
    {
        $lecturers = Lecturer::orderby('created_at', 'desc')->first();

        $numberOfBatch = 0;

        if (is_null($lecturers)) {
            $numberOfBatch = 1;
        } else {
            $numberOfBatch = $lecturers->batch + 1;
        }
        Excel::import(new LecturersImport($numberOfBatch), request()->file('file'));

        return back();
    }
}
