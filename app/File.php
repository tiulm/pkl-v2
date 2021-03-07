<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'files';
    protected $fillable = [
        'internship_student_id', 'transcript', 'krs', 'khs', '	penilaian_pkl', 'bimbingan_pkl', 'sertifikat'
    ];
    public function InternshipStudent()
    {
        return $this->belongsTo(InternshipStudent::class);
    }

    
}
