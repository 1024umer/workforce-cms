<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTask extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_id',
        'project_grid_id',
        'title',
        'description',
        'due_date',
        'is_priority',
        'is_completed',
        'completed_at',
        'user_id',
    ];
    protected $appends = ['is_timer_running'];
    public function project(){
        return $this->belongsTo(Project::class);
    }
    public function assigned(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function grid(){
        return $this->belongsTo(ProjectGrid::class,'project_grid_id');
    }
    public function collaborators(){
        return $this->hasMany(ProjectTaskCollaborator::class);
    }
    public function comments(){
        return $this->hasMany(ProjectTaskComment::class);
    }
    public function timers(){
        return $this->hasMany(ProjectTaskTimer::class);
    }
    public function subtasks(){
        return $this->hasMany(ProjectTaskSubtask::class);
    }
    public function getIsTimerRunningAttribute(){
        return $this->timers()->where('end_time', null)->count();
    }
}
