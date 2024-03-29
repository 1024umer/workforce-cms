<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectInvite extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_id',
        'email',
    ];
    public function project(){
        return $this->belongsTo(Project::class);
    }
}
