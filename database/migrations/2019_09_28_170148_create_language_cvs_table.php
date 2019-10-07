<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguageCvsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('language_cvs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cv_id');
            $table->integer('language_id');
            $table->integer('level'); // [1: Beginner, 2: Conversational, 3: Business, 4: Fluent]

            $table->foreign('cv_id')
                ->references('id')
                ->on('cvs');

            $table->foreign('language_id')
                ->references('id')
                ->on('languages');

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
        Schema::dropIfExists('language_cvs');
    }
}
