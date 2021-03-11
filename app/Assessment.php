<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $table = 'assessments';

    protected $fillable = [
        'group_assessment', 'intern_assessment', 'final_assessment', 'grade', 'internship_student_id', 'group_project_id'
    ];

    public function InternshipStudent() {
        return $this->belongsTo('App\InternshipStudent');
    }

    public function GroupProject() {
        return $this->belongsTo('App\GroupProject');
    }
}
