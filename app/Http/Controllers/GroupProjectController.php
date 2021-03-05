<?php

namespace App\Http\Controllers;

use App\GroupProject;
use App\Jobdesc;
use App\Agency;
use App\File;
use App\GroupProjectSchedule;
use Illuminate\Http\Request;
use App\InternshipStudentGroupProject;
use App\InternshipStudentJobdesc;
use App\InternshipStudent;
use Illuminate\Http\UploadedFile;
use Auth;
use Mail;
use Carbon\Carbon;
use App\Exports\GroupProjectExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Mail\ProjectCreated;
use App\Mail\SeminarCreated;

class GroupProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $job = Jobdesc::orderBy('status', 'desc')->get();
        $pk = GroupProject::with(['Agency', 'InternshipStudents.User', 'InternshipStudents' => function ($abc) {
            $abc->with(['Jobdescs', 'File']);
        }])->where('id', $id)->first();

        $ini = Auth::user()->InternshipStudent->id;
        
        if($pk->count() != 0){
            $mhs = $pk->InternshipStudents->count();
            $gue = 0;
            foreach ($pk->InternshipStudents as $s) {
                if($s->id == $ini){
                    $gue = 1;
                }
            }
            if ($gue == 1 && $pk->is_verified != 4) {
                return view('college_student.edit', compact(['pk', 'mhs', 'gue', 'job']));
            } else{
                echo '<script type="text/javascript">
                alert("Error!!! Ini bukan kelompok Anda.")</script>';
                return redirect(route('mahasiswa.home'));
            }
        }
        else{
            $mhs = $pk->InternshipStudents->count();
            return view('college_student.edit', compact(['pk', 'mhs', 'job']));
        }
    }

    public function editAnggota($id)
    {
        $mhs = InternshipStudent::with(['Jobdescs', 'File', 'GroupProjects'])->where('id', $id)->first();

        $job = Jobdesc::orderBy('status', 'desc')->get();

        return response()->json(['data' => $mhs, 'job' => $job]);
    }
    
    public function updateAnggota(Request $request)
    {
        $student = InternshipStudent::where('nim', $request->editNim)->first();

        InternshipStudentJobdesc::whereInternshipStudentId($student->id)->delete();

        foreach ($request->input('editJobdesc') as $jobdesc) {
            $student->Jobdescs()->attach($jobdesc);
        }

        $berkas = FIle::where('internship_student_id', $student->id)->first();
        
        if ($request->hasFile('editTranskrip')) {
            $fileTranskrip = $request->file('editTranskrip');
            $folderTranskrip = 'berkas/transkrip';
            $fileNameTranskrip =  Carbon::now()->timestamp . '_' . uniqId() . '_transkrip';
            $fileTranskrip->move($folderTranskrip, $fileNameTranskrip);
            $berkas->transcript = $fileNameTranskrip;
            $berkas->save();
        }
        if ($request->hasFile('editKrs')) {
            $fileKrs = $request->file('editKrs');
            $folderKrs = 'berkas/krs';
            $fileNameKrs =  Carbon::now()->timestamp . '_' . uniqId() . '_krs';
            $fileKrs->move($folderKrs, $fileNameKrs);
            $berkas->krs = $fileNameKrs;
            $berkas->save();
        }
        if ($request->hasFile('editKhs')) {
            $fileKhs = $request->file('editKhs');
            $folderKhs = 'berkas/khs';
            $fileNameKhs =  Carbon::now()->timestamp . '_' . uniqId() . '_khs';
            $fileKhs->move($folderKhs, $fileNameKhs);
            $berkas->khs = $fileNameKhs;
            $berkas->save();
        }
        if ($request->hasFile('editNilaiPKL')) {
            $fileNilai = $request->file('editNilaiPKL');
            $folderNilai = 'berkas/nilaiPKL';
            $fileNameNilai = Carbon::now()->timestamp . '_' . uniqId() . '_nilaiPKL';
            $fileNilai->move($folderNilai, $fileNameNilai);
            $berkas->penilaian_pkl = $fileNameNilai;
            $berkas->save();
        }
        if ($request->hasFile('editSertifikat')) {
            $fileSertifikat = $request->file('editSertifikat');
            $folderSertifikat = 'berkas/sertifikat';
            $fileNameSertifikat = Carbon::now()->timestamp . '_' . uniqId() . '_sertifikat';
            $fileSertifikat->move($folderSertifikat, $fileNameSertifikat);
            $berkas->sertifikat = $fileNameSertifikat;
            $berkas->save();
        }
        if ($request->hasFile('editLkmm')) {
            $fileSertifikatLKMM = $request->file('editLkmm');
            $folderSertifikatLKMM = 'berkas/LKMM';
            $fileNameSertifikatLKMM = Carbon::now()->timestamp . '_' . uniqId() . '_sertifikatLKMM';
            $fileSertifikatLKMM->move($folderSertifikatLKMM, $fileNameSertifikatLKMM);
            $berkas->sertifikat_lkmm = $fileNameSertifikatLKMM;
            $berkas->save();
        }
            
        return redirect(route('mahasiswa.edit', $request->groupIdEdit));
    }

    public function tambahAnggota(Request $request)
    {
        $groupProject = GroupProject::with('InternshipStudents')->where('id', $request->groupId)->first();
        // dd($groupProject);
        $groupProject->InternshipStudents()->attach(InternshipStudent::where('nim', $request->nim)->first()->id);
            $student = InternshipStudent::where('nim', $request->nim)->first();
                foreach ($request->input('jobdesc') as $jobdesc) {
                    $student->Jobdescs()->attach($jobdesc);
                }

            if ($request->hasFile('transkrip')) {
                $fileTranskrip = $request->file('transkrip');
                $folderTranskrip = 'berkas/transkrip';
                $fileNameTranskrip =  Carbon::now()->timestamp . '_' . uniqId() . '_transkrip';
                $fileTranskrip->move($folderTranskrip, $fileNameTranskrip);
            }
            if ($request->hasFile('krs')) {
                $fileKrs = $request->file('krs');
                $folderKrs = 'berkas/krs';
                $fileNameKrs =  Carbon::now()->timestamp . '_' . uniqId() . '_krs';
                $fileKrs->move($folderKrs, $fileNameKrs);
            }
            if ($request->hasFile('khs')) {
                $fileKhs = $request->file('khs');
                $folderKhs = 'berkas/khs';
                $fileNameKhs =  Carbon::now()->timestamp . '_' . uniqId() . '_khs';
                $fileKhs->move($folderKhs, $fileNameKhs);
            }

            $berkas = new File;
            $berkas->internship_student_id = $student->id;
            $berkas->transcript = $fileNameTranskrip;
            $berkas->krs = $fileNameKrs;
            $berkas->khs = $fileNameKhs;
            $berkas->save();

        return redirect(route('mahasiswa.edit', $request->groupId));
    }

    public function hapus(Request $request)
    {
        $student = InternshipStudent::where('id', $request->internship_student_id)->first();

        InternshipStudentJobdesc::whereInternshipStudentId($student->id)->delete();
        File::where('internship_student_id', $student->id)->delete();
        
        $group = GroupProject::where('id', $request->groupProject)->first();
        $student->GroupProjects()->detach($group->id);

        return redirect(route('mahasiswa.edit', $request->groupProject));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $i = 1;

        foreach ($request->nim as $nim) {
            $request->validate(
                [
                    'nama-' . $i => 'required',
                    'ipk-' . $i => 'gt:2.49',
                    'sks-' . $i => 'gt:90',
                    'jobdesc_' . $i => 'required',
                    'khs_' . $i => 'required',
                    'transkrip_' . $i => 'required',
                    'krs_' . $i => 'required',
                    'instansi' => 'required',
                    'bidang' => 'required',
                    'alamat' => 'required',
                    'tlp' => 'required|numeric|gt:11',
                    'start' => 'required|date',
                    'end' => 'required|date|after:start',
                    'kak' => 'required'
                ],
                [
                    'required' => 'Harap di isi',
                    'numeric' => 'Hanya boleh di isi menggunakan angka',
                    'min' => 'Minimal :min karakter',
                    'nama-' . $i . '.required' => 'NIM tidak tersedia atau sedang cuti',
                    'ipk-' . $i . '.gt' => 'Minimal 2.5',
                    'sks-' . $i . '.gt' => 'Minimal 90',
                ]
            );
        }
        
        $student = new InternshipStudent();
        $agency = Agency::create([
            'agency_name' => $request->instansi,
            'sector' =>  $request->bidang,
            'address' => $request->alamat,
            'phone_number' => $request->tlp
        ]);
        
        if ($request->hasFile('kak')) {
            $filekak = $request->file('kak');
            $folderkak = 'berkas/kak';
            $fileNamekak =  Carbon::now()->timestamp . '_' . uniqId() . '_kak';
            $filekak->move($folderkak, $fileNamekak);
        }

        $groupProject = new GroupProject;
            $groupProject->start_intern = $request->input('start');
            $groupProject->end_intern = $request->input('end');
            $groupProject->agency_id = $agency->id;
            $groupProject->kak = $fileNamekak;

            $groupProject->save();

        foreach ($request->nim as $nim) {

            $groupProject->InternshipStudents()->attach(InternshipStudent::where('nim', $nim)->first()->id);
            $student = InternshipStudent::where('nim', $nim)->first();
                foreach ($request->input('jobdesc_' . $i) as $jobdesc) {
                    $student->Jobdescs()->attach($jobdesc);
                }
            
            // $student->name = $request->input('nama-' . $i);
            // $student->ipk = $request->input('ipk-' . $i);
            // $student->sks = $request->input('sks-' . $i);
            $student->status = "S";
            $student->update();

            if ($request->hasFile('transkrip_' . $i)) {
                $fileTranskrip = $request->file('transkrip_' . $i);
                $folderTranskrip = 'berkas/transkrip';
                $fileNameTranskrip =  Carbon::now()->timestamp . '_' . uniqId() . '_transkrip';
                $fileTranskrip->move($folderTranskrip, $fileNameTranskrip);
            }
            if ($request->hasFile('krs_' . $i)) {
                $fileKrs = $request->file('krs_' . $i);
                $folderKrs = 'berkas/krs';
                $fileNameKrs =  Carbon::now()->timestamp . '_' . uniqId() . '_krs';
                $fileKrs->move($folderKrs, $fileNameKrs);
            }
            if ($request->hasFile('khs_' . $i)) {
                $fileKhs = $request->file('khs_' . $i);
                $folderKhs = 'berkas/khs';
                $fileNameKhs =  Carbon::now()->timestamp . '_' . uniqId() . '_khs';
                $fileKhs->move($folderKhs, $fileNameKhs);
            }

            $berkas = new File;
            $berkas->internship_student_id = $student->id;
            $berkas->transcript = $fileNameTranskrip;
            $berkas->krs = $fileNameKrs;
            $berkas->khs = $fileNameKhs;
            $berkas->save();

            $i++;
        };

        $data = GroupProject::with(['InternshipStudents', 'Agency'])->where('id', $groupProject->id)->first();

        Mail::to('ti@ulm.ac.id')->send(new ProjectCreated($data));
        

        return redirect()->route('mahasiswa.home')->with('status', 'Berhasil Mendaftar');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GroupProject  $groupProject
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $student = InternshipStudent::whereNim($request->nim)->whereStatus($request->status)->first();

        return response()->json($student);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GroupProject  $groupProject
     * @return \Illuminate\Http\Response
     */
    public function getVerif($id)
    {
        $groupProject = GroupProject::with('InternshipStudents.User')->find(Auth::user()->InternshipStudent->getGroupProjectId());
        return response()->json(['data' => $groupProject]);
    }

    public function accSeminar(Request $request, $id)
    {
        $i=1;
        $verif = GroupProject::with('InternshipStudentGroupProject')->find($id);
        
        if ($request->hasFile('setuju')) {
            $fileSetuju = $request->file('setuju');
            $folderSetuju = 'berkas/persetujuan';
            $fileNameSetuju =  Carbon::now()->timestamp . '_' . uniqId() . '_persetujuan';
            $fileSetuju->move($folderSetuju, $fileNameSetuju);
        }
        
        $verif->persetujuan = $fileNameSetuju;
        
            
        foreach ($verif->InternshipStudentGroupProject as $udin) {
                if ($request->hasFile('nilaiPKL_'.$i)) {
                    $fileNilai = $request->file('nilaiPKL_'.$i);
                    $folderNilai = 'berkas/nilaiPKL';
                    $fileNameNilai = Carbon::now()->timestamp . '_' . uniqId() . '_nilaiPKL';
                    $fileNilai->move($folderNilai, $fileNameNilai);
                }
                if ($request->hasFile('sertifikatLkmm_'.$i)) {
                    $fileSertifikatLKMM = $request->file('sertifikatLkmm_'.$i);
                    $folderSertifikatLKMM = 'berkas/LKMM';
                    $fileNameSertifikatLKMM = Carbon::now()->timestamp . '_' . uniqId() . '_sertifikatLKMM';
                    $fileSertifikatLKMM->move($folderSertifikatLKMM, $fileNameSertifikatLKMM);
                }
                $berkas = File::where('internship_student_id', $udin->internship_student_id)->first();
                $berkas->penilaian_pkl = $fileNameNilai;
                $berkas->sertifikat_lkmm = $fileNameSertifikatLKMM;
                $berkas->save();
            
                $i++;
        }
        $verif->is_verified = $request->is_verified + '1';
        $verif->save();

        $data = GroupProject::with(['InternshipStudents', 'Agency'])->where('id', $verif->id)->first();

        Mail::to('ti@ulm.ac.id')->send(new SeminarCreated($data));

        return redirect(route('mahasiswa.home')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GroupProject  $groupProject
     * @return \Illuminate\Http\Response
     */
    public function export()
    {
        return Excel::download(new GroupProjectExport, 'DataPKMerge.xlsx');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GroupProject  $groupProject
     * @return \Illuminate\Http\Response
     */
    public function destroy(GroupProject $groupProject)
    {
        //
    }
}
