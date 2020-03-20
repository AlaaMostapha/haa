<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CompanyTasksMajorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_tasks_majors', function (Blueprint $table) {
            //
            $table->bigIncrements('id');

            
            $table->unsignedBigInteger('company_task_id')->nullable();
            $table->foreign('company_task_id')->references('id')->on('company_tasks')->onDelete('cascade');

            $table->unsignedBigInteger('major_id')->nullable();
            $table->foreign('major_id')->references('id')->on('majors')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_tasks_majors', function (Blueprint $table) {
            //
            Schema::dropIfExists('company_tasks_majors');

        });  
    }
}
