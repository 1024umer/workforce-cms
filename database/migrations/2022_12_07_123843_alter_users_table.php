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
        Schema::table('users', function (Blueprint $table) {
            $table->string('favourite_color')->nullable();
            $table->string('favourite_movie')->nullable();
            $table->string('favourite_book')->nullable();
            $table->string('favourite_animal')->nullable();
            $table->string('favourite_food')->nullable();
            $table->string('hobbies')->nullable();
            $table->string('dream_vacation')->nullable();
            $table->string('pet_peeves')->nullable();
            $table->string('biggest_fear')->nullable();
            $table->string('superpowers')->nullable();
            $table->string('onewish')->nullable();
            $table->string('talent')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('favourite_color');
            $table->dropColumn('favourite_movie');
            $table->dropColumn('favourite_book');
            $table->dropColumn('favourite_animal');
            $table->dropColumn('favourite_food');
            $table->dropColumn('hobbies');
            $table->dropColumn('dream_vacation');
            $table->dropColumn('pet_peeves');
            $table->dropColumn('biggest_fear');
            $table->dropColumn('superpowers');
            $table->dropColumn('onewish');
            $table->dropColumn('talent');
        });
    }
};
