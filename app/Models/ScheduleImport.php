<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleImport extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'execute_time',
        'execute',
        'created_at',
        'updated_at',
    ];
}
