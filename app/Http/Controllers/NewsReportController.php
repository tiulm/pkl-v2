<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GroupProject;
use App\Lecturer;
use App\InternshipStudent;
use App\GroupProjectSchedule;
use App\GroupProjectExaminer;
use App\GroupProjectSupervisor;

class NewsReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $groupProject = GroupProject::with(['Agency', 'GroupProjectSchedule', 'InternshipStudents' => function ($abc) {
            $abc->with(['Jobdescs', 'File']);
        }])->find($id);
        $groupProjectCount = GroupProject::withCount(['InternshipStudents'])->where('id', $id)->first();
        $count = $groupProjectCount->internship_students_count + 1;
        $examiners = GroupProjectExaminer::with('Lecturer')->where('group_project_id', $groupProject->id)->get();
        $supervisors = GroupProjectSupervisor::with('Lecturer')->where('group_project_id', $groupProject->id)->first();
        $projectManager = GroupProject::with(['InternshipStudents'  => function ($abc) {
            $abc->whereHas('Jobdescs', function($q) {
                $q->where('jobdesc_id', '=', 1);
            });
        }])->find($id);

        // dd(['groupProject' => $groupProject, 'examiner' => $examiner, 'supervisor' => $supervisor]);

        return view('document.newsreport', compact('groupProject', 'examiners', 'supervisors', 'count', 'projectManager'));
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
    public function destroy($id)
    {
        //
    }
}
