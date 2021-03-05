<?php

namespace App\Exports;

use App\GroupProject;
use App\InternshipStudent;
use App\Jobdesc;
use App\GroupProjectSchedule;
use App\GroupProjectExaminer;
use App\GroupProjectSupervisor;
use App\Lecturer;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class GroupProjectExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $groupProject = GroupProject::with(['GroupProjectSchedule', 'InternshipStudents.Jobdescs', 'GroupProjectExaminer.Lecturer', 'GroupProjectSupervisor.Lecturer'])
        ->where('is_verified', '>=', '4')->get();
        return view('exports.datapkmerge', [
            'datas' => $groupProject
        ]);
    }
}
