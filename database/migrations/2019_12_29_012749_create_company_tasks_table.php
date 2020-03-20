<?php

use App\Models\CompanyTask;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->string('status', 170)->index()->default(CompanyTask::STATUS_NEW);
            $table->string('title', 170)->index();
            $table->date('startDate')->nullable();
            $table->date('endDate')->nullable();
            $table->unsignedInteger('price')->nullable();
            $table->string('major')->nullable();
            $table->unsignedTinyInteger('requiredNumberOfUsers')->nullable();
            $table->unsignedTinyInteger('appliedUsersCount')->default(0);
            $table->unsignedTinyInteger('hiredUsersCount')->default(0);
            $table->text('briefDescription')->nullable();
            $table->text('fullDescription')->nullable();
            $table->boolean('suspendedByAdmin')->default(false);
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
        Schema::dropIfExists('company_tasks');
    }
}
