<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTaskTimer extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_id',
        'project_task_id',
        'user_id',
        'project_grid_id',
        'start_time',
        'end_time',
    ];
}
