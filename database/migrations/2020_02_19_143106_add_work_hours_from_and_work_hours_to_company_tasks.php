<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWorkHoursFromAndWorkHoursToCompanyTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_tasks', function (Blueprint $table) {
            //
            $table->string('workHoursFrom')->nullable();
            $table->string('workHoursTo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_tasks', function (Blueprint $table) {
            //
            $table->dropColumn('workHoursFrom');
            $table->dropColumn('workHoursTo');
        });
    }
}
