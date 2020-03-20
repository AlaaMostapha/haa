<?php

use App\Models\CompanyTaskUserApply;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyTaskUserAppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_task_user_applies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_task_id');
            $table->foreign('company_task_id')->references('id')->on('company_tasks')->onDelete('cascade');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('status', 170)->index()->default(CompanyTaskUserApply::STATUS_APPLIED);
            $table->unique(['user_id', 'company_task_id']);
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
        Schema::dropIfExists('company_task_user_applies');
    }
}
