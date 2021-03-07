<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InternshipLogActivity extends Model
{
    protected $table = 'internship_log_activities';

    protected $fillable = [
        'date', 'description', 'internship_student_id'
    ];

    public function InternshipStudent()
    {
        return $this->belongsTo(InternshipStudent::class);
    }
}
