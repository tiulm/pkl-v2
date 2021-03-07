<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jobdesc extends Model
{
    protected $guarded = ['id'];
    protected $table = 'jobdescs';

    public function InternshipStudents()
    {
        return $this->belongsToMany('App\InternshipStudent', 'internship_student_jobdesc', 'jobdesc_id', 'internship_student_id');
    }
}
