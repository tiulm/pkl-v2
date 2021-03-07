<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GroupProject;
use App\Lecturer;
use App\InternshipStudent;
use App\GroupProjectSchedule;
use App\GroupProjectExaminer;
use App\GroupProjectSupervisor;
use App\Observer;
use Auth;
use PDF;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $seminar = GroupProject::with(['Agency', 'GroupProjectSchedule' => function ($abc) {
            $abc->with('Observer');
        }, 'GroupProjectSupervisor' => function ($ccd) {
            $ccd->with('Lecturer');
        }, 'InternshipStudents' => function ($abc) {
            $abc->with('User');
        }])->where('is_verified', '3')->get();
        
        if($seminar->count() != 0){
            $ini = Auth::user()->InternshipStudent->id;
            foreach ($seminar as $s) {
                    $pengamat[] = $s->GroupProjectSchedule->Observer->where('internship_student_id', $ini)->count();
                    $peserta[] = $s->GroupProjectSchedule->Observer->where('group_project_schedule_id', $s->GroupProjectSchedule->id)->count();
                    $gua[] = $s->InternshipStudents->where('id', $ini)->count();
            }
            $res = [
                'seminar' => $seminar,
                'pengamat' => $pengamat,
                'peserta' => $peserta,
                'gua' => $gua
            ];
    
            // dd($gua);
            return view('college_student.seminar', $res);
        }
        else{
            return view('college_student.seminar', compact('seminar'));
        }
    }

    public function get()
    {
        $verified = GroupProject::with(['Agency', 'GroupProjectSchedule', 'GroupProjectSupervisor' => function ($ccd) {
            $ccd->with('Lecturer');
        }, 'InternshipStudents' => function ($abc) {
            $abc->with('User');
        }])->where('is_verified', '3')->get();
        return response()->json(['data' => $verified]);
    }

    public function detailDaftar($id)
    {
        $Anggota = GroupProject::with(['Agency', 'InternshipStudents' => function ($abc) {
            $abc->with(['Jobdescs', 'File']);
        }])->find($id);
        $fck = GroupProjectExaminer::with('Lecturer')->where('group_project_id', $Anggota->id)->get();
        $supervisor = GroupProjectSupervisor::with('Lecturer')->where('group_project_id', $Anggota->id)->first();
        return response()->json(['data' => $Anggota, 'fck' => $fck, 'supervisor' => $supervisor]);
    }

    public function hadiriSeminar($id)
    {
        $Anggota = GroupProject::with(['Agency', 'InternshipStudents' => function ($abc) {
            $abc->with(['Jobdescs', 'File']);
        }])->find($id);
        $fck = GroupProjectExaminer::with('Lecturer')->where('group_project_id', $Anggota->id)->get();
        $supervisor = GroupProjectSupervisor::with('Lecturer')->where('group_project_id', $Anggota->id)->first();
        return response()->json(['data' => $Anggota, 'fck' => $fck, 'supervisor' => $supervisor]);
    }
    
    public function absen($id)
    {
        $groupProject = GroupProject::with(['Agency', 'GroupProjectSchedule', 'InternshipStudents' => function ($abc) {
            $abc->with(['Jobdescs', 'File']);
        }])->find($id);
        $supervisors = GroupProjectSupervisor::with('Lecturer')->where('group_project_id', $groupProject->id)->first();
        $projectManager = GroupProject::with(['InternshipStudents'  => function ($abc) {
            $abc->whereHas('Jobdescs', function($q) {
                $q->where('jobdesc_id', '=', 1);
            });
        }])->find($id);


        return view('document.absen', compact('groupProject', 'supervisors', 'projectManager'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function yakin(Request $request)
    {
        // dd($request);
        $student = InternshipStudent::where('id', $request->internship_student_id)->first();
        $group = GroupProjectSchedule::where('group_project_id', $request->groupProject)->first();
        $observer = Observer::where('group_project_schedule_id', $group->id)->count();
        
        if($observer < $group->quota){
            $student->GroupProjectSchedules()->attach($group->id);
            return redirect(route("agenda.list"));
        }
        else{
            echo '<script type="text/javascript">
            alert("Pendaftaran Gagal! Kuota sudah terpenuhi.");
            window.location.href="/mahasiswa/seminar";</script>';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = \DB::table('group_projects_schedules')
        ->join('observers', 'group_projects_schedules.id', '=', 'observers.group_project_schedule_id')
        ->join('internship_students', 'observers.internship_student_id', '=', 'internship_students.id')
        ->where('group_project_id', '=', $id)
        ->get();

        return response()->json(['data' => $student]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $student = InternshipStudent::where('id', $request->internship_student_id)->first();
        $group = GroupProjectSchedule::where('group_project_id', $request->groupProject)->first();
        $student->GroupProjectSchedules()->detach($group->id);
        
        return redirect(route("agenda.list"));
    }

    public function destroyFromKoor(Request $request)
    {
        $student = InternshipStudent::where('id', $request->internship_student_id)->first();
        $group = GroupProjectSchedule::where('group_project_id', $request->groupProject)->first();
        $student->GroupProjectSchedules()->detach($group->id);
        
        return redirect(route("seminar.list"));
    }
}
