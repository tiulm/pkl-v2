<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InternshipProgress extends Model
{
    protected $table = 'internship_progresses';

    protected $fillable = [
        'date', 'description', 'agreement', 'internship_student_id'
    ];

    public function InternshipStudent()
    {
        return $this->belongsTo(InternshipStudent::class);
    }
}
