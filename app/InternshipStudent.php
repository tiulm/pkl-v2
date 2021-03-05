<?php

namespace App;

use App\GroupProject;

use Illuminate\Database\Eloquent\Model;

class InternshipStudent extends Model
{
    protected $guarded = ['id'];
    public function GroupProjects()
    {
        return $this->belongsToMany('App\GroupProject', 'internship_student_group_project', 'internship_student_id', 'group_project_id');
    }
    public function GroupProjectSchedules()
    {
        return $this->belongsToMany('App\GroupProjectSchedule', 'observers', 'internship_student_id', 'group_project_schedule_id');
    }
    public function Observer() {
        return $this->hasMany(Observer::class);
    }
    public function Jobdescs()
    {
        return $this->belongsToMany('App\Jobdesc', 'internship_student_jobdesc', 'internship_student_id', 'jobdesc_id');
    }

    public function File()
    {
        return $this->hasOne(File::class);
    }
    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function getGroupProjectId()
    {
        $internshipStudentId = $this->id;

        $internshipStudent = $this->with('GroupProjects')->findOrFail($internshipStudentId);

        if ($internshipStudent->GroupProjects->count() === 0) {
            return null;
        }
        return $internshipStudent->GroupProjects[0]->id;
    }

    public function groupProjectVerified()
    {
        $groupProject = new GroupProject();

        if ($this->getGroupProjectId()) {
            return $groupProject->findOrFail($this->getGroupProjectId())->is_verified;
        }

        return;
    }
    public function groupProjectProgress()
    {
        $groupProject = new GroupProject();

        if ($this->getGroupProjectId()) {
            return $groupProject->findOrFail($this->getGroupProjectId())->progress;
        }

        return false;
    }
    
    public function InternProgress() {
        return $this->hasMany('App\InternshipProgress');
    }

    public function LogAct() {
        return $this->hasMany('App\InternshipLogActivity');
    }
}
