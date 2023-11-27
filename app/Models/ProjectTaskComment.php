<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\ProjectTaskComment as ProjectTaskCommentNotification;
class ProjectTaskComment extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_id',
        'project_task_id',
        'comment',
        'user_id',
        'comment_type',
    ];
    protected $with = ['files'];
    protected $appends = ['created_at_formatted'];
    public function project(){
        return $this->belongsTo(Project::class, 'project_id');
    }
    public function task(){
        return $this->belongsTo(ProjectTask::class, 'project_task_id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function getCreatedAtFormattedAttribute(){
        return date('l, F d, Y \a\t h:i a', strtotime($this->created_at));
    }
    public static function boot() {
	    parent::boot();
	    static::created(function($item) {
            foreach($item->task->collaborators as $collaborator){
                if($item->user_id!=$collaborator->user_id){
                    $collaborator->user->notify(new ProjectTaskCommentNotification($item));
                }
            }
	    });   
	}
    public function files(){
        return $this->morphMany(File::class,'fileable');
    }
}
