<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupProjectSupervisor extends Model
{
    protected $table = 'group_projects_supervisors';
    protected $fillable = [
        'group_project_id',  'lecturer_id'
    ];
    public function GroupProject() {
        return $this->belongsTo('App\GroupProject');
    }
    public function Lecturer() {
        return $this->belongsTo('App\Lecturer');
    }
}
