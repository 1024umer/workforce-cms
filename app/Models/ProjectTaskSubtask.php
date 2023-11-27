<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTaskSubtask extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_id',
        'project_task_id',
        'is_completed',
        'description',
    ];
}
