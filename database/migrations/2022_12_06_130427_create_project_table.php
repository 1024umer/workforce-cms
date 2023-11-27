<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title', 355);
            $table->text('description')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
        Schema::create('project_grids', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained();
            $table->string('grid_name');
            $table->integer('order');
            $table->timestamps();
        });
        Schema::create('project_collaborators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
        Schema::create('project_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained();
            $table->foreignId('project_grid_id')->constrained();
            $table->string('title', 355);
            $table->text('description')->nullable();
            $table->timestamps();
        });
        Schema::create('project_task_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained();
            $table->foreignId('project_task_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->text('comment');
            $table->timestamps();
        });
        Schema::create('project_task_collaborators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained();
            $table->foreignId('project_task_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
        Schema::dropIfExists('project_grids');
        Schema::dropIfExists('project_collaborators');
        Schema::dropIfExists('project_tasks');
        Schema::dropIfExists('project_task_comments');
        Schema::dropIfExists('project_task_collaborators');
    }
};
