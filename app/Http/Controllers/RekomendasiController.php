<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Lecturer;
use App\Recommendation;
use App\InternshipStudentGroupProject;
use Auth;
use Mail;
use App\Mail\RecommendationTaken;


class RekomendasiController extends Controller
{
	public function index()
	{
		$rek = Recommendation::with(['Lecturer', 'InternshipStudent' => function ($abc) {
            $abc->with('User');
        }])->get();
		// dd($rek);
		$lecture = Lecturer::get();
		return view('coordinator.index', compact(['rek', 'lecture']));

	}

	public function indexStudent()
	{
		$ini = Auth::user()->InternshipStudent->id;
		$rek = Recommendation::with('Lecturer')->get();
		$group = InternshipStudentGroupProject::get();
		$groupgua = 0;
		foreach($group as $g){
			if($g->internship_student_id == $ini){
				$groupgua = 1;
			}
		}
		if($rek->count() != 0){
            foreach ($rek as $s) {
				$countGua = $s->where('internship_student_id', $ini)->count();
			}
            $res = [
				'rek' => $rek,
				'groupgua' => $groupgua,
				'countGua' => $countGua
            ];
            return view('college_student.recommendation', $res);
        }
        else{
            return view('college_student.recommendation', compact('rek'));
        }

	}

	public function store(Request $request)
	{
		$rek = new Recommendation;
        $rek->agency = $request->input('instansi');
        $rek->description = $request->input('deskripsi');
		$rek->status = 0;
        $rek->lecturer_id = $request->input('supervisor');

		$rek->save();
		return redirect('koor/rekomendasi');
	}

	public function storeStudent(Request $request)
	{
		$rek = Recommendation::with(['InternshipStudent', 'Lecturer'])->findOrFail($request->rekId);
        $rek->internship_student_id = $request->input('internship_student_id');
		$rek->status = 1;
		
		$rek->update();
		
		$data = Recommendation::with(['InternshipStudent', 'Lecturer'])->findOrFail($rek->id);

		Mail::to('ti@ulm.ac.id')->send(new RecommendationTaken($data));
		return redirect('mahasiswa/rekomendasi');
	}

	// update data rekomendasi
	public function update(Request $request)
	{
		$rek = Recommendation::findOrFail($request->rekId);
		$rek->agency = $request->input('instansi');
		$rek->description = $request->input('deskripsi');
		if($request->input('supervisor') != null){
			$rek->lecturer_id = $request->input('supervisor');
		}
		$rek->update();
		return redirect('koor/rekomendasi');
	}

	// method untuk hapus data rekomendasi
	public function hapus(Request $request)
	{
		$rek = Recommendation::findOrFail($request->rekId);
		$rek->delete();
		return redirect('koor/rekomendasi');
	}

	public function batal(Request $request)
	{
		$rek = Recommendation::findOrFail($request->rekIdBatal);
		$rek->status = 0;
		$rek->internship_student_id = null;
		$rek->update();
		
		return redirect('koor/rekomendasi');
	}
	
	public function batalStudent(Request $request)
	{
		$rek = Recommendation::findOrFail($request->rekIdBatal);
		$rek->status = 0;
		$rek->internship_student_id = null;
		$rek->update();
		
		return redirect('mahasiswa/rekomendasi');
	}
}