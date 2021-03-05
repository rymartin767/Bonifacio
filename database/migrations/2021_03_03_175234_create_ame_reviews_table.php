<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmeReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ame_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ame_id')->references('id')->on('ames');
            $table->unsignedBigInteger('emp_id');
            $table->text('comment');
            $table->smallInteger('rating');
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
        Schema::dropIfExists('ame_reviews');
    }
}
