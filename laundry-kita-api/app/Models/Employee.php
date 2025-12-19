<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'grade_id',
        'shift_id',
        'attendance_status',
        'job_status',
        'contact',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function grade()
    {
        return $this->belongsTo(EmployeeGrade::class, 'grade_id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }
}
