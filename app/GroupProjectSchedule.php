<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class GroupProjectSchedule extends Model
{
    
    protected $table = 'group_projects_schedules';
    protected $appends = ['day', 'tanggal'];
    protected $fillable = [
        'date', 'place', 'time', 'time_end', 'group_project_id', 'quota'
    ];

    public function GroupProject() {
        return $this->belongsTo('App\GroupProject');
    }
    public function InternshipStudents() {
        return $this->belongsToMany('App\InternshipStudent', 'observers', 'internship_student_id', 'group_project_schedule_id');
    }
    public function formatDateWithDayName($date)
    {
        setlocale(LC_TIME, 'id_ID.utf8');
        return $date->formatLocalized('%A');
    }
    public function formatDate($date)
    {
        setlocale(LC_TIME, 'id_ID.utf8');
        return $date->formatLocalized('%d %B %Y');
    }

    public function getDayAttribute()
    {
        return $this->formatDateWithDayName(Carbon::parse($this->date));
    }
    public function getTanggalAttribute()
    {
        return $this->formatDate(Carbon::parse($this->date));
    }
    public function Observer() {
        return $this->hasMany(Observer::class);
    }
}
