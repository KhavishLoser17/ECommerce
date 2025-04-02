<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Schedule;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'title',
        'working_hours_start',
        'working_hours_end',
        'email',
        'phone',
        'course',
        'classes',
        'profile_image',
    ];
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->title} {$this->first_name} {$this->last_name}";
    }

    public function getWorkingHoursAttribute()
    {
        return date('h:i A', strtotime($this->working_hours_start)) . ' - ' .
               date('h:i A', strtotime($this->working_hours_end));
    }
}
