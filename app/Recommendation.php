<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    protected $table = 'recommendations';
    protected $fillable = [
        'agency', 'description', 'status', 'lecturer_id', 'internship_student_id'
    ];
    public function InternshipStudent() {
        return $this->belongsTo('App\InternshipStudent');
    }
    public function Lecturer() {
        return $this->belongsTo('App\Lecturer');
    }
}
