<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'image_profile', 'phone_number'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($value) {
        $this->attributes['password'] = bcrypt($value);
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id');
    }

    public function InternshipStudent()
    {
        return $this->hasOne(InternshipStudent::class);
    }

    public function isStudent()
    {
        foreach ($this->roles as $role) {
            if ($role->role_name === 'mahasiswa') return true;
        }
        return false;
    }
    public function isStudentRegistered()
    {
        foreach ($this->roles as $role) {
            if ($role->role_name === 'mahasiswa') return true;
        }
        return false;
    }
    public function isAdmin()
    {
        foreach ($this->roles as $role) {
            if ($role->role_name === 'admin') return true;
        }
        return false;
    }
    public function isCoordinator()
    {
        foreach ($this->roles as $role) {
            if ($role->role_name === 'koordinator') return true;
        }
        return false;
    }
    
    public function hasRoles($roleName)
    {
        foreach ($this->roles as $role) {
            if ($role->role_name === $roleName) return true;
        }
        return false;
    }
    public function redirectTo()
    {
        if ($this->isCoordinator()) {
            return 'coordinator.home';

        } elseif ($this->isAdmin()) {
            return 'admin.home';

        } elseif ($this->isStudent()) {
            return 'mahasiswa.home';    
        } 
    }

    public function getInternshipStudentId(){
        return Auth::user()->InternshipStudent->id;
    }

    public function isVerifiedGroupProject(){
        return $this->InternshipStudent->groupProjectVerified();
    }

    public function isProgressGroupProject(){
        return $this->InternshipStudent->groupProjectProgress();
    }

    public static function convertTitleForNewsReport($title) { 
        $titleExplode = explode(" ", $title); $titles = []; $i = 6; 
        foreach ($titleExplode as $index => $title) { 
            if ($index == $i) { $titles[] = $title . '~%'; $i += 6; 
            } else { $titles[] = $title; } 
        } 
        $implode = implode(" ", $titles); 
        return explode("~% ", $implode); 
    }
    public static function convertDay($day)
    {
        $indonesian = "";
        if($day === "Monday"){
            $indonesian = "Senin";
        }
        else if($day === "Tuesday"){
            $indonesian = "Selasa";
        }
        else if($day === "Wednesday"){
            $indonesian = "Rabu";
        }
        else if($day === "Thursday"){
            $indonesian = "Kamis";
        }
        else if($day === "Friday"){
            $indonesian = "Jumat";
        }
        else if($day === "Saturday"){
            $indonesian = "Sabtu";
        }
        else if($day === "Sunday"){
            $indonesian = "Minggu";
        }

        return $indonesian;
    }
    public static function convertTanggal($tanggal)
    {
        $explode = explode(" ", $tanggal);

        $indonesian = "";
        if($explode[1] === "January"){
            $indonesian = "Januari";
        }
        else if($explode[1] === "February"){
            $indonesian = "Februari";
        }
        else if($explode[1] === "March"){
            $indonesian = "Maret";
        }
        else if($explode[1] === "May"){
            $indonesian = "Mei";
        }
        else if($explode[1] === "June"){
            $indonesian = "Juni";
        }
        else if($explode[1] === "July"){
            $indonesian = "Juli";
        }
        else if($explode[1] === "August"){
            $indonesian = "Agustus";
        }
        else if($explode[1] === "October"){
            $indonesian = "Oktober";
        }
        else if($explode[1] === "December"){
            $indonesian = "Desember";
        }

        return $explode[0]. " " . $indonesian . " " . $explode[2];
    }
}