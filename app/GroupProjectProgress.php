<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupProjectProgress extends Model
{
    protected $table = 'group_projects_progresses';

    protected $fillable = [
        'date', 'description', 'agreement', 'group_project_id'
    ];
    
    public function GroupProject() {
        return $this->belongsTo('App\GroupProject');
    }
}
