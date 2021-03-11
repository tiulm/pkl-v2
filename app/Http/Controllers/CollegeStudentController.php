<?php

namespace App\Http\Controllers;

use App\Jobdesc;
use App\User;
use App\InternshipStudent;
use App\GroupProject;
use App\GroupProjectExaminer;
use App\Imports\StudentsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;


class CollegeStudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $job = Jobdesc::orderBy('status', 'desc')->get();
        $anggota = GroupProject::with(['Agency', 'Assessment', 'GroupProjectSchedule', 'InternshipStudents.Jobdescs', 'InternshipStudents.User', 'InternshipStudents.Observer', 'InternshipStudents.Assessment', 'GroupProjectSupervisor.Lecturer'])
            ->find(Auth::user()->InternshipStudent->getGroupProjectId());
        
        if ($anggota !== null) {
            $history = [];
            foreach ($anggota->InternshipStudents as $key => $i){
                $history[$key] = $i->history + $i->Observer->count();
            }
            $noHistory = count(array_keys($history, 0));

            $fck = GroupProjectExaminer::with('Lecturer')->where('group_project_id', $anggota->id)->get();
            return view('college_student.home', compact(['job', 'anggota', 'fck', 'noHistory']));
        }
        
        return view('college_student.home', compact(['job', 'anggota']));
    }

    public function show($id)
    {
        $project = GroupProject::findOrFail($id);
        return response()->json(['data' => $project]);
    }

    public function update(Request $request, $id)
    {
        $project = GroupProject::with('Agency')->findOrFail($id);
        $project->title = $request->input('editJudul');
        $project->field_supervisor = $request->input('editPemLapangan');
        $project->Agency->agency_name = $request->input('editInstansi');
        $project->Agency->sector = $request->input('editBidang');
        $project->Agency->address = $request->input('editAlamat');
        $project->Agency->phone_number = $request->input('editKontak');
        $project->Agency->update();
        
        $pkl = InternshipStudent::where('id', Auth::user()->InternshipStudent->id)->first();
        $pkl->title = $request->input('editJudulPKL');
        $pkl->update();

        if ($project->save()) {
            return response()->json("success");
        }
        return response()->json("failed");
    }

    public function upload(Request $request, $id)
    {
        $project = GroupProject::findOrFail($id);
        if ($request->hasFile('laporan')) {
            $fileLaporan = $request->file('laporan');
            $folderLaporan = 'berkas/laporan';
            $fileNameLaporan =  Carbon::now()->timestamp . '_' . uniqId() . 'LaporanPK';
            $fileLaporan->move($folderLaporan, $fileNameLaporan);
        }
        $project->laporan = $fileNameLaporan;

        if ($project->save()) {
            return response()->json("success");
        }
        return response()->json("failed");
    }
}
