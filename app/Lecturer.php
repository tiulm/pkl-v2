<?php

namespace App;

use App\GroupProjectExaminer;
use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    protected $guarded = ['id'];

    public function examiners()
    {
        return $this->hasMany(GroupProjectExaminer::class);
    }
    
    public function GroupProject() 
    {
        return $this->belongsToMany ('App\GroupProject', 'group_projects_supervisors', 'lecturer_id' , 'group_project_id');
    }

    public function getSupervisor() 
    {
        return $this->hasMany(GroupProjectSupervisor::class);
    }
}
