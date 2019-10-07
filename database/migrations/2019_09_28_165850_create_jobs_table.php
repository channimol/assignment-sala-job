<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('requirement')->nullable();
            $table->integer('salary')->nullable();
            $table->integer('job_source_id')->nullable();  // [1: internal, 2:external]
            $table->integer('schedule_type_id')->nullable();  // [1: fulltime, 2:parttime]
            $table->integer('department_id')->nullable();
            $table->integer('published_by');
            
            $table->foreign('department_id')
                ->references('id')
                ->on('departments');

            $table->foreign('published_by')
                ->references('id')
                ->on('users');
                    
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
        Schema::dropIfExists('jobs');
    }
}
