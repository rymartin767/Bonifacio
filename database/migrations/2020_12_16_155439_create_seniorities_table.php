<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSenioritiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seniorities', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('sen');
            $table->smallInteger('phire');
            $table->integer('emp');
            $table->date('doh')->index();
            $table->string('seat')->index();
            $table->string('fleet')->index();
            $table->string('domicile')->index();
            $table->date('retire')->index();
            $table->boolean('active')->index();
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
        Schema::dropIfExists('seniorities');
    }
}