<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Mail;
use App\Mail\ProjectCreated;
use App\GroupProject;
use App\InternshipStudent;

class SertifikatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $student = GroupProject::with(['Agency', 'GroupProjectSchedule' => function ($abc) {
            $abc->with('Observer');
        }, 'GroupProjectSupervisor' => function ($ccd) {
            $ccd->with('Lecturer');
        }, 'InternshipStudents' => function ($abc) {
            $abc->with('User');
        }])->where('is_verified', '>=', '4')->get();
        // dd($student);

        return view('college_student.watched', compact('student'));
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
        $data = GroupProject::with(['InternshipStudents', 'Agency'])->where('id', $request->groupProject)->first();
        return view('mail.create', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $userId)
    {
        $data = GroupProject::with(['InternshipStudents', 'Agency', 'GroupProjectSchedule.Observer'])->where('id', $id)->first();
        $pengamat = $data->GroupProjectSchedule->Observer->where('internship_student_id', $userId)->first();
        $student = InternshipStudent::where('id', $pengamat->internship_student_id)->first();
        return view('document.sertifikat', compact(['data', 'student']));
    }

    public function mailTest(Request $request)
    {
        
        $data = GroupProject::with(['InternshipStudents', 'Agency'])->where('id', $request->groupProject)->first();

        // return view('mail.create', compact('data'));
        // dd($data);
        Mail::to('zainuddin.karnaini@gmail.com')->send(new ProjectCreated($data));
         
        return redirect(route('watched-list'));
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
