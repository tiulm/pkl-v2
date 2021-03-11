<?php

namespace App\Http\Controllers;

use App\GroupProjectSupervisor;
use App\GroupProject;
use App\Term;
use Illuminate\Http\Request;
use App\Exports\SupervisorExport;
use Maatwebsite\Excel\Facades\Excel;

class GroupProjectSupervisorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $term = Term::all();
        return view('archive.supervisor', compact('term'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        $verified = GroupProject::with(['Agency', 'Term', 'GroupProjectSupervisor' => function ($ccd) {
            $ccd->with('Lecturer');
        }, 'InternshipStudents' => function ($abc) {
            $abc->with('User');
        }])->where('is_verified', '>', '0')->get();
        return response()->json(['data' => $verified]);
    }

    public function getFiltered($id)
    {
        if ($id == 0){
            $verified = GroupProject::with(['Agency', 'Term', 'GroupProjectSupervisor' => function ($ccd) {
                $ccd->with('Lecturer');
            }, 'InternshipStudents' => function ($abc) {
                $abc->with('User');
            }])->where('is_verified', '>', '0')->get();
        } else {
            $verified = GroupProject::with(['Agency', 'Term', 'GroupProjectSupervisor' => function ($ccd) {
                $ccd->with('Lecturer');
            }, 'InternshipStudents' => function ($abc) {
                $abc->with('User');
            }])->where('is_verified', '>', '0')->where('term_id', $id)->get();
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
     * @param  \App\GroupProjectSupervisor  $groupProjectSupervisor
     * @return \Illuminate\Http\Response
     */
    public function show(GroupProjectSupervisor $groupProjectSupervisor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GroupProjectSupervisor  $groupProjectSupervisor
     * @return \Illuminate\Http\Response
     */
    public function edit(GroupProjectSupervisor $groupProjectSupervisor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GroupProjectSupervisor  $groupProjectSupervisor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GroupProjectSupervisor $groupProjectSupervisor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GroupProjectSupervisor  $groupProjectSupervisor
     * @return \Illuminate\Http\Response
     */
    public function destroy(GroupProjectSupervisor $groupProjectSupervisor)
    {
        //
    }

    public function export(Request $request)
    {
        $data = $request->filterTA;
        if ($data == 0){
            $verified = GroupProject::with(['Agency', 'Term', 'GroupProjectSupervisor' => function ($ccd) {
                $ccd->with('Lecturer');
            }, 'InternshipStudents' => function ($abc) {
                $abc->with('User');
            }])->where('is_verified', '>', '0')->get();
        } else {
            $verified = GroupProject::with(['Agency', 'Term', 'GroupProjectSupervisor' => function ($ccd) {
                $ccd->with('Lecturer');
            }, 'InternshipStudents' => function ($abc) {
                $abc->with('User');
            }])->where('is_verified', '>', '0')->where('term_id', $data)->get();
        }
        $term = Term::where('id', $data)->first();
        return view('document.rekapPembimbing', [
            'data' => $verified, 'semester' => $data, 'term' => $term
        ]);
        // return Excel::download(new SupervisorExport, 'Data Pembimbing PKL-PK.xlsx');
    }
}
