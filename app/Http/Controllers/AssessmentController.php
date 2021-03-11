<?php

namespace App\Http\Controllers;

use App\Assessment;
use App\GroupProject;
use App\Term;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $term = Term::all();
        // dd($term);
        return view('archive.assessment', compact('term'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        $nilai = \DB::table('assessments')
            ->join('internship_students', 'assessments.internship_student_id', '=', 'internship_students.id')
            ->join('group_projects', 'assessments.group_project_id', '=', 'group_projects.id')
            ->join('group_projects_schedules', 'group_projects_schedules.group_project_id', '=', 'group_projects.id')
            ->join('terms', 'group_projects_schedules.term_id', '=', 'terms.id')
            ->get();
        return response()->json(['data' => $nilai]);
    }

    public function getFiltered($id)
    {
        if ($id == 0){
            $nilai = \DB::table('assessments')
            ->join('internship_students', 'assessments.internship_student_id', '=', 'internship_students.id')
            ->join('group_projects', 'assessments.group_project_id', '=', 'group_projects.id')
            ->join('group_projects_schedules', 'group_projects_schedules.group_project_id', '=', 'group_projects.id')
            ->join('terms', 'group_projects_schedules.term_id', '=', 'terms.id')
            ->get();
        } else {
            $nilai = \DB::table('assessments')
                ->join('internship_students', 'assessments.internship_student_id', '=', 'internship_students.id')
                ->join('group_projects', 'assessments.group_project_id', '=', 'group_projects.id')
                ->join('group_projects_schedules', 'group_projects_schedules.group_project_id', '=', 'group_projects.id')
                ->join('terms', 'group_projects_schedules.term_id', '=', 'terms.id')
                ->where('group_projects_schedules.term_id', '=', $id)
                ->get();
        }
            return response()->json(['data' => $nilai]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $groupProject = GroupProject::with('InternshipStudents')->find($id);
        
        foreach ($groupProject->InternshipStudents as $mhs) {
            $assessment = Assessment::updateOrCreate(
                ['internship_student_id' => $mhs->id],
                [
                    'group_project_id' =>$id,
                    'group_assessment' => $request->input('kelompokTotalRata'),
                    'intern_assessment' => $request->input('rerata' . $mhs->id),
                    'final_assessment' => $request->input('akhir' . $mhs->id),
                    'grade' => $request->input('huruf' . $mhs->id),
                ]
            );
        }

        if ($assessment->save()) {
            return response()->json("success");
        }
        return response()->json("failed");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Assessment  $assessment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $groupProject = GroupProject::with(['Agency', 'GroupProjectSchedule.Term', 'InternshipStudents' => function ($abc) {
            $abc->with(['Jobdescs', 'File', 'Assessment']);
        }])->find($id);
        
        return response()->json(['data' => $groupProject]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Assessment  $assessment
     * @return \Illuminate\Http\Response
     */
    public function edit(Assessment $assessment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Assessment  $assessment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Assessment $assessment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Assessment  $assessment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assessment $assessment)
    {
        //
    }

    public function export(Request $request)
    {
        $data = $request->filterTA;
        if ($data == 0){
            $nilai = \DB::table('assessments')
            ->join('internship_students', 'assessments.internship_student_id', '=', 'internship_students.id')
            ->join('group_projects', 'assessments.group_project_id', '=', 'group_projects.id')
            ->join('group_projects_schedules', 'group_projects_schedules.group_project_id', '=', 'group_projects.id')
            ->join('terms', 'group_projects_schedules.term_id', '=', 'terms.id')
            ->get();
        } else {
            $nilai = \DB::table('assessments')
                ->join('internship_students', 'assessments.internship_student_id', '=', 'internship_students.id')
                ->join('group_projects', 'assessments.group_project_id', '=', 'group_projects.id')
                ->join('group_projects_schedules', 'group_projects_schedules.group_project_id', '=', 'group_projects.id')
                ->join('terms', 'group_projects_schedules.term_id', '=', 'terms.id')
                ->where('group_projects_schedules.term_id', '=', $data)
                ->get();
        }
        $term = Term::where('id', $data)->first();
        return view('document.rekapNilai', [
            'data' => $nilai, 'semester' => $data, 'term' => $term
        ]);
        // return Excel::download(new SupervisorExport, 'Data Pembimbing PKL-PK.xlsx');
    }
}
