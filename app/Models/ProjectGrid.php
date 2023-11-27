<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectGrid extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_id',
        'grid_name',
        'order',
    ];
    public function project(){
        return $this->belongsTo(Project::class);
    }
    public function tasks(){
        return $this->hasMany(ProjectTask::class);
    }
}
