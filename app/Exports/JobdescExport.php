<?php

namespace App\Exports;
use App\Jobdesc;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class JobdescExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $mhs = Jobdesc::get();
        return view('exports.jobdesc', [
            'datas' => $mhs
        ]);
    }
}
