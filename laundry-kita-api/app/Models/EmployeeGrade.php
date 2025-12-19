<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeGrade extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'role',
        'allowance',
        'benefit',
    ];
}
