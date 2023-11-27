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
        Schema::table('project_tasks', function (Blueprint $table) {
            $table->date('due_date')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->integer('is_completed')->default(0);
            $table->integer('is_priority')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_tasks', function (Blueprint $table) {
            $table->dropColumn([
                'due_date',
                'completed_at',
                'is_completed',
                'is_priority'
            ]);
        });
    }
};
