<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterWorkHoursFromAndWorkHoursToCompanyTasks extends Migration
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
            $table->dropColumn('workHoursFrom');
            $table->dropColumn('workHoursTo');
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
            $table->time('workHoursFrom')->nullable();
            $table->time('workHoursTo')->nullable();
        });
    }
}
