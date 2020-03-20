<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('university_email')->nullable();
            
            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');

            $table->string('skills')->nullable();
            $table->string('howDidYouFindUsOther')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            
            $table->dropForeign(['city_id']);
            $table->dropColumn('city_id');
            $table->dropColumn('skills');
            $table->dropColumn('university_email');
            $table->dropColumn('howDidYouFindUsOther');
        });
    }
}
