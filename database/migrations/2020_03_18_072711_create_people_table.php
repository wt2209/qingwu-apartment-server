<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 4)->default('');
            $table->string('gender', 2)->default('男');
            $table->string('education')->nullable()->comment('学历');
            $table->string('serial', 20)->nullable()->comment('工号');
            $table->string('identify', 18)->nullable()->comment('身份证号');
            $table->string('phone', 13)->nullable();
            $table->string('department', 20)->nullable()->comment('部门');
            $table->date('hired_at')->default('1000-01-01')->comment('入职时间');
            $table->date('contract_start')->default('1000-01-01')->comment('劳动合同开始日');
            $table->date('contract_end')->default('1000-01-01')->comment('劳动合同结束日');
            $table->string('emergency_person', 4)->nullable()->comment('紧急联系人');
            $table->string('emergency_phone', 13)->nullable()->comment('紧急联系电话');
            $table->string('origin')->nullable()->comment('籍贯');
            $table->string('spouse')->nullable()->comment('配偶');
            $table->string('spouse_identify')->nullable();
            $table->string('remark')->nullable();
            $table->index('name');
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
        Schema::dropIfExists('people');
    }
}
