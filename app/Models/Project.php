<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'color_code',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function collaborators(){
        return $this->hasMany(ProjectCollaborator::class);
    }
    public function grids(){
        return $this->hasMany(ProjectGrid::class)->orderBy('order','asc');
    }
    public function tasks(){
        return $this->hasMany(ProjectTask::class);
    }
}
