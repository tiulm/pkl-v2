<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GroupProject;
use App\Lecturer;
use App\Observer;
use App\GroupProjectSchedule;
use App\GroupProjectExaminer;
use App\GroupProjectSupervisor;

class SeminarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $verified = GroupProject::all();
        return view('coordinator.seminar');
    }

    public function examiner()
    {
        $examiner = Lecturer::all();
        return view('coordinator.seminar') . compact('examiner');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        $verified = GroupProject::with(['Agency', 'GroupProjectSupervisor' => function ($ccd) {
            $ccd->with('Lecturer');
        }, 'InternshipStudents' => function ($abc) {
            $abc->with('User');
        }])->where('is_verified', '2')->get();
        return response()->json(['data' => $verified]);
    }

    public function detailDaftar($id)
    {
        $Anggota = GroupProject::with(['Agency', 'InternshipStudents' => function ($abc) {
            $abc->with(['Jobdescs', 'File', 'Observer']);
        }])->find($id);
        $fck = GroupProjectExaminer::with('Lecturer')->where('group_project_id', $Anggota->id)->get();
        $supervisor = GroupProjectSupervisor::with('Lecturer')->where('group_project_id', $Anggota->id)->first();
        return response()->json(['data' => $Anggota, 'fck' => $fck, 'supervisor' => $supervisor]);
    }

    public function detailArsip($id)
    {
        $Anggota = GroupProject::with(['Agency', 'InternshipStudents' => function ($abc) {
            $abc->with(['Jobdescs', 'File']);
        }])->find($id);
        $fck = GroupProjectExaminer::with('Lecturer')->where('group_project_id', $Anggota->id)->get();
        $supervisor = GroupProjectSupervisor::with('Lecturer')->where('group_project_id', $Anggota->id)->first();
        $groupProject = GroupProject::with(['GroupProjectSchedule'])->findOrFail($id);
        return response()->json(['data' => $Anggota, 'fck' => $fck, 'schedule' => $groupProject, 'supervisor' => $supervisor]);
    }

    public function terima($id)
    {
        $getIsVerif = GroupProject::with('GroupProjectSupervisor.Lecturer')->findOrFail($id);
        // dd($getIsVerif);
        return response()->json(['data' => $getIsVerif]);
    }
    public function seminar()
    {
        $verified = GroupProject::with(['Agency', 'GroupProjectExaminer.Lecturer', 'GroupProjectSchedule.Observer', 'InternshipStudents' => function ($abc) {
            $abc->with('User');
        }])->where('is_verified', '3')->get();
        
        return response()->json(['data' => $verified]);
        
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verifikasi(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'tempat' => 'required',
                'tanggal' => 'required|date',
                'waktuMulai' => 'required',
                'waktuSelesai' => 'required',
                'kuota' => 'required',
            ],
            [
                'required' => 'Harap di isi',
            ]
        );
        $jadwal =  new GroupProjectSchedule([
            'date' => $request->tanggal,
            'place' => $request->tempat,
            'time' => $request->waktuMulai,
            'time_end' => $request->waktuSelesai,
            'quota' => $request->kuota,
            'group_project_id' => $id,
        ]);
        $penguji = new Lecturer();
        $penguji = ([
            [
                'role' => $request->examiner_1['role'],
                'lecturer_id' => $request->examiner_1['lecturer_id'],
                'group_project_id' => $id
            ],
            [
                'role' => $request->examiner_2['role'],
                'lecturer_id' => $request->examiner_2['lecturer_id'],
                'group_project_id' => $id
            ],
            [
                'role' => $request->examiner_3['role'],
                'lecturer_id' => $request->examiner_3['lecturer_id'],
                'group_project_id' => $id
            ],
            // [
            //     'role' => $request->examiner_4['role'],
            //     'lecturer_id' => $request->examiner_4['lecturer_id'],
            //     'group_project_id' => $id
            // ]
        ]);
        foreach ($penguji as $data) {
            $examiners = new GroupProjectExaminer([
                'role' => $data['role'],
                'lecturer_id' => $data['lecturer_id'],
                'group_project_id' => $id
            ]);
            $examiners->save();
            // dd($examiners);
        }
        $jadwal->save();
        $verif = GroupProject::findOrFail($id);
        $verif->is_verified = $request->is_verified + '1';
        if ($verif->save()) {
            return response()->json("success");
        }
        return response()->json("failed");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $getIsVerif = GroupProject::with(['GroupProjectSupervisor.Lecturer', 'GroupProjectSchedule'])->findOrFail($id);

        return response()->json(['data' => $getIsVerif]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getSeminar($id)
    {
        $groupProject = GroupProject::with(['GroupProjectSupervisor.Lecturer', 'GroupProjectSchedule'])->findOrFail($id);
        $examiner = GroupProjectExaminer::with(['Lecturer'])->where('group_project_id', $groupProject->id)->get();
        return response()->json(['data' => $groupProject, 'examiner' => $examiner]);
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
        $groupProject = GroupProject::with('GroupProjectExaminer')->findOrFail($id);
        $examiner = GroupProjectExaminer::where('group_project_id', $groupProject->id)->get();
        $jadwal =  GroupProjectSchedule::where('group_project_id', $groupProject->id)->first();
        $jadwal->date = $request->input('editTanggal');
        $jadwal->place = $request->input('editTempat');
        $jadwal->time = $request->input('editStart');
        $jadwal->time_end = $request->input('editEnd');
        $jadwal->quota = $request->input('editKuota');
        $jadwal->update();
        $i = 1;
        foreach ($examiner as $val) {
            // dd($val);
            if ($request->input('editExaminerId_' . $i)){
                $val->lecturer_id = $request->input('editExaminerId_' . $i);
                $val->update();
            }
            $i++;
        }

        if ($jadwal->save()) {
            return response()->json("success");
        }
        return response()->json("failed");
    }

    public function isDone(Request $request, $id)
    {
        $verif = GroupProject::findOrFail($id);
        $verif->is_verified = $request->is_verified + '1';
        $bimbingan = \DB::table('lecturers')
            ->join('group_projects_supervisors', 'lecturers.id', '=', 'group_projects_supervisors.lecturer_id')
            ->where('group_projects_supervisors.group_project_id', '=', $verif->id)
            ->decrement('quota');
        if ($verif->save()) {
            return response()->json("success");
        }
        return response()->json("failed");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $groupProject = GroupProject::find($id)->decrement('is_verified');
    }
}
