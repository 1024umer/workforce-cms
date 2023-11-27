<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\{Project, ProjectGrid, User};
use Illuminate\Support\Facades\Hash;
use App\Constants\TaskTypes;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        User::create([
            'name'=>'admin',
            'email'=>'admin@crm.com',
            'user_type'=>1,
            'password'=>Hash::make('12345678')
        ]);
        $taskTypes = TaskTypes::getTaskTypes();
        $project = Project::create([
            'title'=>'Workforce',
            'user_id'=>1,
            'description'=>'This Project is for workforce management and it is default'
        ]);
        foreach($taskTypes as $taskTypek => $taskType){
            $project->grids()->create([
                'grid_name'=>$taskType,
                'order'=>$taskTypek,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
};
