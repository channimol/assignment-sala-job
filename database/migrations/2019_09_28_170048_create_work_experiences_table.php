<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_experiences', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cv_id');
            $table->string('title');
            $table->string('company');
            $table->text('location')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->text('description');
            $table->text('references'); //link or information related to position

            $table->foreign('cv_id')
                ->references('id')
                ->on('cvs');

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
        Schema::dropIfExists('work_experiences');
    }
}
