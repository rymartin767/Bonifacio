<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacanciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('base_seniority');
            $table->integer('emp');
            $table->string('base');
            $table->string('fleet');
            $table->string('seat');
            $table->string('award_base')->index();
            $table->string('award_fleet')->index();
            $table->string('award_seat')->index();
            $table->boolean('upgrade')->index();
            $table->boolean('new_hire');
            $table->date('month')->index();
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
        Schema::dropIfExists('vacancies');
    }
}
