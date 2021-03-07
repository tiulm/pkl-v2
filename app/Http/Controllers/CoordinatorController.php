<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InternshipStudent;
use App\GroupProject;
use App\Agency;
use App\File;
use App\Lecturer;
use App\GroupProjectSupervisor;
use App\InternshipStudentJobdesc;
use App\InternshipStudentGroupProject;
use App\GroupProjectSchedule;

class CoordinatorController extends Controller
{
    public function index()
    {
        $daftar = GroupProject::where('is_verified', '0')->count();
        $mahasiswa = \DB::table('internship_student_group_project')
            ->join('group_projects', 'internship_student_group_project.group_project_id', '=', 'group_projects.id')
            ->where('is_verified', '=', 1)
            ->count();
        $progress = GroupProject::where('is_verified', '1')->count();
        $seminar = GroupProject::where('is_verified', '2')->count();
        $agenda = GroupProject::with('GroupProjectSchedule')->where('is_verified', '3')->get();

        return view('coordinator.home', compact(['daftar', 'progress', 'mahasiswa', 'seminar', 'agenda']));
    }

    public function project_team()
    {
        $lecture = Lecturer::All();
        $daftar = GroupProject::where('is_verified', '0')->count();
        return view('coordinator.project_team', compact('lecture', 'daftar'));
    }

    public function seminar()
    {
        $examiner = Lecturer::All();
        $seminar = GroupProject::where('is_verified', '2')->count();
        return view('coordinator.seminar', compact('examiner', 'seminar'));
    }

    public function get()
    {
        $GroupProject = GroupProject::with(['Agency', 'InternshipStudents' => function ($abc) {
            $abc->with('User');
        }])->where('is_verified', '0')->get();
        return response()->json(['data' => $GroupProject]);
    }

    public function getVerif($id)
    {
        $Anggota = GroupProject::with(['Agency', 'InternshipStudents' => function ($abc) {
            $abc->with(['Jobdescs', 'File']);
        }])->find($id);
        return response()->json(['data' => $Anggota]);
    }

    public function getIsVerif($id)
    {
        $getIsVerif = GroupProject::with('GroupProjectSupervisor.Lecturer')->findOrFail($id);
        return response()->json(['data' => $getIsVerif]);
    }

    public function verifikasi(Request $request, $id)
    {
        $GroupProject = new GroupProjectSupervisor([
            'group_project_id' => $id,
            'lecturer_id' => $request->supervisor
        ]);

        $GroupProject->save();
        $verif = GroupProject::findOrFail($id);
        $verif->is_verified = $request->is_verified + '1';
        $quota = Lecturer::find($request->supervisor);
        $bimbingan = $quota->quota + 1;
        $quota->update(['quota' => $bimbingan]);

        if ($verif->save()) {
            return response()->json("success");
        }
        return response()->json("failed");
    }

    public function getVerified()
    {
        $verified = GroupProject::with(['Agency', 'GroupProjectSupervisor' => function ($ccd) {
            $ccd->with('Lecturer');
        }, 'InternshipStudents' => function ($abc) {
            $abc->with('User');
        }])->where('is_verified', '1')->get();
        return response()->json(['data' => $verified]);
    }

    public function tolak($id)
    {
        $groupProject = GroupProject::with('InternshipStudents')->find($id);
        $groupProject->Agency()->delete();

        foreach ($groupProject->InternshipStudents as $udin) {
            InternshipStudentJobdesc::whereInternshipStudentId($udin->id)->delete();
            File::whereInternshipStudentId($udin->id)->delete();
            $udin->status = "A";
            $udin->update();
        }

        $groupProject->delete();
    }
    public function hapus(Request $request, $id)
    {
        $groupProject = GroupProject::with('InternshipStudents')->find($id);
        $bimbingan = \DB::table('lecturers')
            ->join('group_projects_supervisors', 'lecturers.id', '=', 'group_projects_supervisors.lecturer_id')
            ->where('group_projects_supervisors.group_project_id', '=', $groupProject->id)
            ->decrement('quota');

        $groupProject->Agency()->delete();

        foreach ($groupProject->InternshipStudents as $udin) {
            InternshipStudentJobdesc::whereInternshipStudentId($udin->id)->delete();
            File::whereInternshipStudentId($udin->id)->delete();
        }

        $groupProject->delete();
    }

    public function getSupervisor($id)
    {
        $groupProject = GroupProject::with('GroupProjectSupervisor.Lecturer')->findOrFail($id);
        $dosen = Lecturer::get();
        return response()->json(['data' => $groupProject, 'dosen' => $dosen]);
    }

    public function updateSupervisor(Request $request, $id)
    {
        $groupProject = GroupProject::findOrFail($id);
        $bimbingan = \DB::table('lecturers')
            ->join('group_projects_supervisors', 'lecturers.id', '=', 'group_projects_supervisors.lecturer_id')
            ->where('group_projects_supervisors.group_project_id', '=', $groupProject->id)
            ->decrement('quota');
        $supervisor = \DB::table('group_projects_supervisors')
            ->where('group_project_id', '=', $groupProject->id)
            ->update(['lecturer_id' => $request->supervisor]);
        $quota = \DB::table('lecturers')
            ->where('id', '=', $request->supervisor)
            ->increment('quota');
        if ($groupProject->save()) {
            return response()->json("success");
        }
        return response()->json("failed");
    }
    public function showArsip()
    {
        return view('coordinator.report');
    }

    public function arsipAll()
    {
        $verified = GroupProject::with(['Agency', 'GroupProjectSchedule', 'InternshipStudents' => function($abc) {
            $abc->with('User');
        }])->where('is_verified', '4')->get();
        
        foreach ($verified as $v){
            $v->increment('is_verified');
            foreach ($v->InternshipStudents as $i) {
                $i->status = "L";
                $i->update();
            }
        }
    }
}
