<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupProject extends Model
{
    protected $guarded = ['id'];
    protected $fillable = [
        'start_intern', 'end_intern', 'agency_id'
    ];
    public function InternshipStudents() {
        return $this->belongsToMany('App\InternshipStudent', 'internship_student_group_project', 'group_project_id', 'internship_student_id');
    }
    
    public function StudentJobdesc() {
        return $this->hasManyThrough(
            'App\Jobdesc',
            'App\InternshipStudent'
        );
    }
    public function Lecturer() {
        return $this->belongsToMany ('App\Lecturer', 'group_projects_supervisors', 'group_project_id', 'lecturer_id');
    }

    public function Agency() {
        return $this->belongsTo('App\Agency');
    }

    public function InternshipStudentGroupProject() {
        return $this->hasMany(InternshipStudentGroupProject::class);
    }
    public function GroupProjectSupervisor()
    {
        return $this->hasOne('App\GroupProjectSupervisor');
    }
    public function GroupProjectSchedule()
    {
        return $this->hasOne('App\GroupProjectSchedule');
    }
    public function GroupProjectExaminer()
    {
        return $this->hasMany('App\GroupProjectExaminer');
    }
    public function GroupProjectNewsReport()
    {
        return $this->hasMany('App\GroupProjectNewsReport');
    }

    public function getVerifiedGroupProject($groupProjectId){
        $groupProject = $this->findOrFail($groupProjectId); 

        return $groupProject->id;
    }
    public function GroupProjectProgress() {
        return $this->hasMany('App\GroupProjectProgress');
    }
}
