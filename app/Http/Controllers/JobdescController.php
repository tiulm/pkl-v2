<?php

namespace App\Http\Controllers;

use App\Jobdesc;
use Illuminate\Http\Request;
use App\Imports\JobdescsImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class JobdescController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('data.jobdesc');
    }

    public function get() {
        $jobdescs = Jobdesc::orderby('id', 'DESC')->get();
        return response()->json(['data' => $jobdescs]);
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
        $this->validate(
            $request,
            [
                'jobname' => 'required|unique:jobdescs,jobname'
            ],
            [
                'required' => 'Harap di isi',
                'unique' => 'Jobdesc sudah ada'
            ]

        );

        $jobdescs = new Jobdesc;
        $jobdescs->jobname = $request->input('jobname');
        $jobdescs->description = $request->input('desk');
        $jobdescs->status = $request->input('status');

        if ($jobdescs->save()) {
            return response()->json("success");
        }
        return response()->json("failed");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Jobdesc  $jobdesc
     * @return \Illuminate\Http\Response
     */
    public function show(Jobdesc $jobdesc)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Jobdesc  $jobdesc
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $job = Jobdesc::findOrFail($id);
        return response()->json(['data' => $job]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Jobdesc  $jobdesc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $jobdesc = Jobdesc::findOrFail($id);
        $jobdesc->jobname = $request->input('jobnameEdit');
        $jobdesc->description = $request->input('deskEdit');
        $jobdesc->status = $request->input('statusEdit');
        if ($jobdesc->save()) {
            return response()->json("success");
        }
        return response()->json("failed");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Jobdesc  $jobdesc
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Jobdesc::find($id)->delete($id);
    }

    public function import()
    {
        $jobdescs = Jobdesc::orderby('created_at', 'desc')->first();

        $numberOfBatch = 0;

        if (is_null($jobdescs)) {
            $numberOfBatch = 1;
        } else {
            $numberOfBatch = $jobdescs->batch + 1;
        }
        Excel::import(new JobdescsImport($numberOfBatch), request()->file('file'));
  
        return back();
    }
}
