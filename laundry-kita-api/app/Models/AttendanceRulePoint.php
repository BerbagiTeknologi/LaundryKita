<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceRulePoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_rule_id',
        'lat',
        'lng',
        'radius_m',
        'name',
    ];

    public function rule()
    {
        return $this->belongsTo(AttendanceRule::class, 'attendance_rule_id');
    }
}
