<?php

namespace App\Exports;
use App\Lecturer;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LecturerExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $mhs = Lecturer::get();
        return view('exports.dosen', [
            'datas' => $mhs
        ]);
    }
}
