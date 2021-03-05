<?php

namespace App\Http\Controllers;

use App\GroupProjectProgress;
use App\InternshipProgress;
use App\InternshipLogActivity;
use Illuminate\Http\Request;
use App\InternshipStudent;
use App\GroupProject;
use App\Agency;
use App\Lecturer;
use App\GroupProjectSupervisor;
use Auth;

class GroupProjectProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $verified = GroupProject::all();
        return view('coordinator.progress');
    }

    public function indexPK()
    {
        $gue = Auth::user()->InternshipStudent->GroupProjects;
        foreach ($gue as $g){
            $pkId = $g->id;
        }
        $group = GroupProject::where('id', $pkId)->first();
        $pk = GroupProjectProgress::where('group_project_id', $group->id)->get();
        return view('college_student.group', compact(['pk', 'group']));
    }

    public function indexPKL()
    {
        $pkl = InternshipProgress::where('internship_student_id', Auth::user()->InternshipStudent->id)->get();
        $log = InternshipLogActivity::where('internship_student_id', Auth::user()->InternshipStudent->id)->get();
        return view('college_student.intern', compact(['pkl', 'log']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function storePK(Request $request)
    {
        $pk = new GroupProjectProgress;
        $pk->date = $request->tanggalProgress;
        $pk->description = $request->deskripsiProgress;
        $pk->agreement = 'N';
        $pk->group_project_id = $request->groupId;
        $pk->save();

        return redirect(route('progress-pk'));
    }
    
    public function destroyPK(Request $request)
    {
        GroupProjectProgress::where('id', $request->groupProject)->delete();
        
        return redirect(route('progress-pk'));
    }
    
    public function storePKL(Request $request)
    {
        $pkl = new InternshipProgress;
        $pkl->date = $request->tanggalProgress;
        $pkl->description = $request->deskripsiProgress;
        $pkl->agreement = 'N';
        $pkl->internship_student_id = $request->internIdProgress;
        $pkl->save();
        
        return redirect(route('progress-pkl'));
    }
    
    public function destroyPKL(Request $request)
    {
        InternshipProgress::where('id', $request->groupProject)->delete();
        
        return redirect(route('progress-pkl'));
    }
    
    public function storeLog(Request $request)
    {
        $log = new InternshipLogActivity;
        $log->date = $request->tanggalLog;
        $log->description = $request->deskripsiLog;
        $log->internship_student_id = $request->internIdLog;
        $log->save();
        
        return redirect(route('progress-pkl'));
    }

    public function destroyLog(Request $request)
    {
        InternshipLogActivity::where('id', $request->logId)->delete();
        
        return redirect(route('progress-pkl'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $request->validate(
            [
                'updateProgress' => 'numeric|min:0|max:100',
                
            ],
            [
                'max' => 'Tidak boleh lebih dari :max',
                'min' => 'Jumlah karakter = :min',
                'numeric' => 'Hanya boleh di isi menggunakan angka',
            ]
        );
        
        $progress = GroupProject::findOrFail($id);
        $progress->progress = $request->input('updateProgress');

        if ($progress->save()) {
            return response()->json("success");
        }
        return response()->json("failed");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GroupProjectProgress  $groupProjectProgress
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $verified = GroupProject::with(['Agency', 'GroupProjectSupervisor' => function($ccd){
            $ccd->with('Lecturer');
        }, 'InternshipStudents' => function($abc) {
            $abc->with('User');
        }])->whereBetween('is_verified', [1, 3])->get();
        return response()->json(['data' => $verified]);
    }

    public function showPK($id)
    {
        $pk = GroupProjectProgress::where('group_project_id', $id)->get();

        return response()->json(['data' => $pk]);
    }

    public function agreePK($id)
    {
        $pk = GroupProjectProgress::where('id', $id)->first();
        $pk->agreement = "Y";
        $pk->update();
    }

    public function agreePKAll($id)
    {
        $pk = GroupProjectProgress::where('group_project_id', $id)->get();
        // dd($pk);
        foreach ($pk as $p) {
            $p->agreement = "Y";
            $p->update();
        }
    }

    public function intern($id)
    {
        $pk = GroupProject::with([ 'InternshipStudents.User', 'InternshipStudents' => function ($abc) {
            $abc->with(['Jobdescs']);
        }])->where('id', $id)->first();

        return view('coordinator.intern', compact(['pk']));
    }

    public function showPKL($id)
    {
        $pkl = InternshipProgress::where('internship_student_id', $id)->get();

        return response()->json(['data' => $pkl]);
    }
    
    public function agreePKL($mhsId)
    {
        $pkl = InternshipProgress::where('id', $mhsId)->first();
        $pkl->agreement = "Y";
        $pkl->update();
    }

    public function agreePKLAll($id)
    {
        $pk = InternshipProgress::where('internship_student_id', $id)->get();
        // dd($pk);
        foreach ($pk as $p) {
            $p->agreement = "Y";
            $p->update();
        }
    }
    
    public function logact($id)
    {
        $pkl = InternshipLogActivity::where('internship_student_id', $id)->get();

        return response()->json(['data' => $pkl]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GroupProjectProgress  $groupProjectProgress
     * @return \Illuminate\Http\Response
     */
    public function edit(GroupProjectProgress $groupProjectProgress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GroupProjectProgress  $groupProjectProgress
     * @return \Illuminate\Http\Response
     */
    public function tampil($id)
    {
        $verified = GroupProject::findOrFail($id);
        return response()->json(['data' => $verified]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GroupProjectProgress  $groupProjectProgress
     * @return \Illuminate\Http\Response
     */
    public function destroy(GroupProjectProgress $groupProjectProgress)
    {
        //
    }
}
