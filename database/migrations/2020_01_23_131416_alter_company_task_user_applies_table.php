<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCompanyTaskUserAppliesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('company_task_user_applies', function (Blueprint $table) {
            $table->bigInteger('rate')->nullable();
            $table->text('review')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('company_task_user_applies', function (Blueprint $table) {
            $table->dropColumn('rate');
            $table->dropColumn('review');
        });
    }

}
