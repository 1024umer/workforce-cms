<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\ProjectTask;
use Hamcrest\Type\IsBoolean;
use Illuminate\Support\Facades\Storage;


class TaskRepository implements BaseRepository {
    public function find($id) : ProjectTask {
        return ProjectTask::find($id);
    }
    public function delete($id){
        $task = $this->find($id);
        $task->delete();
    }
    public function setCommentTypeOther($comment, $id){
        $user_id = auth()->user()->id;
        $task = $this->find($id);
        $task->comments()->create([
            'user_id' => $user_id,
            'comment_type' => 1,
            'project_id' => $task->project_id,
            'comment' => $comment
        ]);
    }
    public function manageCollaborator($id){
        $user_id = auth()->user()->id;
        $task = $this->find($id);
        $check = $task->collaborators()->where('user_id', $user_id)->count();
        $checkProject = $task->project->collaborators()->where('user_id', $user_id)->count();
        if($check==0){
            $task->collaborators()->create([
                'user_id' => $user_id,
                'project_id' => $task->project_id
            ]);
        }
        if($checkProject==0){
            $task->project->collaborators()->create([
                'user_id' => $user_id,
            ]);
        }
        return true;
    }
    public function addCollaborator($id, $user_id){
        $task = $this->find($id);
        $check = $task->collaborators()->where('user_id', $user_id)->count();
        $checkProject = $task->project->collaborators()->where('user_id', $user_id)->count();
        if($check==0){
            $task->collaborators()->create([
                'user_id' => $user_id,
                'project_id' => $task->project_id
            ]);
        }
        if($checkProject==0){
            $task->project->collaborators()->create([
                'user_id' => $user_id,
            ]);
        }
        return true;
    }
    public function deleteCollaborator($id){
        $user_id = auth()->user()->id;
        $task = $this->find($id);
        $task->collaborators()->where('user_id', $user_id)->delete();
        $task->project->collaborators()->where('user_id', $user_id)->delete();
        return true;
    }
    public function deleteCollaboratorUser($id, $user_id){
        $task = $this->find($id);
        $task->collaborators()->where('user_id', $user_id)->delete();
        $task->project->collaborators()->where('user_id', $user_id)->delete();
        return true;
    }
}