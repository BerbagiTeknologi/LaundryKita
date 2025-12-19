<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'grace_minutes',
        'require_gps',
        'require_selfie',
        'require_fingerprint',
        'geofence_lat',
        'geofence_lng',
        'geofence_radius_m',
    ];

    public function points()
    {
        return $this->hasMany(AttendanceRulePoint::class, 'attendance_rule_id');
    }
}
