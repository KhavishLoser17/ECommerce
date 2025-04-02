<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'course_code',
        'course_name',
        'class_group',
        'title',
        'description',
        'schedule_type',
        'date',
        'end_date',
        'start_time',
        'end_time',
        'location',
        'recurrence',
        'days_of_week',
        'recurrence_end',
        'master_schedule_id'
    ];

    protected $appends = ['formatted_time', 'is_recurring'];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function masterSchedule()
    {
        return $this->belongsTo(Schedule::class, 'master_schedule_id');
    }

    public function recurringInstances()
    {
        return $this->hasMany(Schedule::class, 'master_schedule_id');
    }

    public function getFormattedTimeAttribute()
    {
        return date('h:i A', strtotime($this->start_time)) . ' - ' .
               date('h:i A', strtotime($this->end_time));
    }

    public function getIsRecurringAttribute()
    {
        return $this->recurrence !== 'none';
    }

    public function scopeUpcoming($query)
    {
        return $query->where('date', '>=', now()->format('Y-m-d'))
                    ->orderBy('date')
                    ->orderBy('start_time');
    }

    public function scopeRecurringMasters($query)
    {
        return $query->where('recurrence', '!=', 'none')
                   ->whereNull('master_schedule_id');
    }

    public function getTeacherFullNameAttribute()
    {
        return $this->teacher->full_name ?? null;
    }
}
