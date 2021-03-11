<?php

namespace App\Http\Controllers;

use App\GroupProjectExaminer;
use App\GroupProject;
use App\GroupProjectSchedule;
use App\Term;
use Illuminate\Http\Request;

class GroupProjectExaminerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $term = Term::all();
        return view('archive.examiner', compact('term'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        // $verified = \DB::table('group_projects')
        //     ->join('group_projects_schedules', 'group_projects_schedules.group_project_id', '=', 'group_projects.id')
        //     ->join('group_projects_examiners', 'group_projects_examiners.group_project_id', '=', 'group_projects.id')
        //     ->join('terms', 'group_projects_schedules.term_id', '=', 'terms.id')
        //     ->join('lecturers', 'group_projects_examiners.lecturer_id', '=', 'lecturers.id')
        //     ->where('is_verified', '>', '2')
        //     ->get();
        $verified = GroupProjectSchedule::with(['Term', 'GroupProject.GroupProjectExaminer.Lecturer'])
            ->get();
        return response()->json(['data' => $verified]);
    }

    public function getFiltered($id)
    {
        if($id == 0){
            $verified = GroupProjectSchedule::with(['Term', 'GroupProject.GroupProjectExaminer.Lecturer'])
                ->get();
        } else {
            $verified = GroupProjectSchedule::with(['Term', 'GroupProject.GroupProjectExaminer.Lecturer'])
                ->where('term_id', $id)->get();
        }
        return response()->json(['data' => $verified]);
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
     * @param  \App\GroupProjectExaminer  $groupProjectExaminer
     * @return \Illuminate\Http\Response
     */
    public function show(GroupProjectExaminer $groupProjectExaminer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GroupProjectExaminer  $groupProjectExaminer
     * @return \Illuminate\Http\Response
     */
    public function edit(GroupProjectExaminer $groupProjectExaminer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GroupProjectExaminer  $groupProjectExaminer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GroupProjectExaminer $groupProjectExaminer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GroupProjectExaminer  $groupProjectExaminer
     * @return \Illuminate\Http\Response
     */
    public function destroy(GroupProjectExaminer $groupProjectExaminer)
    {
        //
    }

    public function export(Request $request)
    {
        $data = $request->filterTA;
        if($data == 0){
            $verified = GroupProjectSchedule::with(['Term', 'GroupProject.GroupProjectExaminer.Lecturer'])
                ->get();
        } else {
            $verified = GroupProjectSchedule::with(['Term', 'GroupProject.GroupProjectExaminer.Lecturer'])
                ->where('term_id', $data)->get();
        }
        // dd($verified);
        $term = Term::where('id', $data)->first();
        return view('document.rekapPenguji', [
            'data' => $verified, 'semester' => $data, 'term' => $term
        ]);
        // return Excel::download(new SupervisorExport, 'Data Pembimbing PKL-PK.xlsx');
    }
}
