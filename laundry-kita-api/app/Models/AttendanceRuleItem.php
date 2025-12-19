<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceRuleItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'icon_class',
    ];
}
