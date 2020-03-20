<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 170)->nullable()->index();
            $table->string('email', 170)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('username', 170)->unique()->nullable();
            $table->string('mobile')->nullable();
            $table->string('bankAccountNumber')->nullable();
            $table->string('commercialRegistrationNumber')->nullable();
            $table->date('commercialRegistrationExpiryDate')->nullable();
            $table->string('howDidYouFindUs')->nullable();
            $table->string('logo')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('companies');
    }
}
