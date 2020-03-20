<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCompanyTasksTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('company_tasks', function (Blueprint $table) {
            $table->string('type', 170)->nullable();
            $table->unsignedInteger('workHoursCount')->nullable();
            $table->unsignedInteger('workDaysCount')->nullable();
            $table->text('location')->nullable();
            $table->unsignedBigInteger('major_id')->nullable();
            $table->foreign('major_id')->references('id')->on('majors')->onDelete('cascade');
            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->text('cityExistImportance')->nullable();
            $table->string('pricePaymentType', 170)->nullable();
            $table->string('language', 170)->nullable();
            $table->unsignedTinyInteger('willTakeCertificate')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('company_tasks', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('workHoursCount');
            $table->dropColumn('workDaysCount');
            $table->dropColumn('location');
            $table->dropForeign(['major_id']);
            $table->dropColumn('major_id');
            $table->dropForeign(['city_id']);
            $table->dropColumn('city_id');
            $table->dropColumn('cityExistImportance');
            $table->dropColumn('pricePaymentType');
            $table->dropColumn('language');
            $table->dropColumn('willTakeCertificate');
        });
    }

}
