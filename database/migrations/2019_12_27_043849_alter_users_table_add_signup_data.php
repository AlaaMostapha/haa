<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTableAddSignupData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('firstName')->nullable();
            $table->string('lastName')->nullable();
            $table->string('username', 170)->nullable()->index();
            $table->string('mobile')->nullable();
            $table->string('bankAccountNumber')->nullable();
            $table->string('major')->nullable();
            $table->string('yearOfStudy')->nullable();
            $table->string('gpaType')->nullable();
            $table->string('gpa')->nullable();
            $table->text('certificates')->nullable();
            $table->text('experiences')->nullable();
            $table->string('universityName')->nullable();
            $table->string('howDidYouFindUs')->nullable();
            $table->string('personalPhoto')->nullable();
            $table->text('summary')->nullable();
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
            $table->string('name')->after('id');
            $table->dropColumn([
                'firstName', 'lastName', 'username', 'mobile',
                'bankAccountNumber', 'major', 'yearOfStudy', 'gpaType', 'gpa',
                'certificates', 'experiences', 'universityName',
                'howDidYouFindUs', 'personalPhoto', 'summary',
            ]);
        });
    }
}
