<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropMajorFromCompanyTasksTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('company_tasks', function (Blueprint $table) {
            $table->dropColumn('major');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('company_tasks', function (Blueprint $table) {
            $table->string('major')->nullable();
        });
    }

}
