<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmeRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ame_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ame_id')->constrained();
            $table->unsignedBigInteger('user_id');
            $table->unsignedSmallInteger('rating');
            $table->timestamps();

            $table->unique(['ame_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ame_ratings');
    }
}
