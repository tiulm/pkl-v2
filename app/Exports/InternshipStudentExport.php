<?php

namespace App\Exports;
use App\InternshipStudent;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class InternshipStudentExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $mhs = InternshipStudent::get();
        return view('exports.mahasiswa', [
            'datas' => $mhs
        ]);
    }
}
