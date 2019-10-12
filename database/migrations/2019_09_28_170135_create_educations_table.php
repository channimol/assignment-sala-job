<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEducationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('educations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cv_id');
            $table->string('school');
            $table->string('field_study')->nullable();
            $table->string('degree')->nullable();
            $table->string('grade')->nullable();
            $table->dateTime('start_year');
            $table->dateTime('end_year');
            $table->text('description')->nullable();
            $table->text('references')->nullable(); //link or information related to position

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
        Schema::dropIfExists('educations');
    }
}
