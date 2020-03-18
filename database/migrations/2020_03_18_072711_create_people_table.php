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
            $table->unsignedBigInteger('area_id')->default(0);
            $table->string('name', 4)->default('');
            $table->string('gender', 2)->default('男');
            $table->string('education')->default('')->comment('学历');
            $table->string('serial', 20)->default('')->comment('工号');
            $table->string('identify', 18)->default('')->comment('身份证号');
            $table->string('phone', 13)->default('');
            $table->string('department', 20)->default('')->comment('部门');
            $table->date('hired_at')->default('1000-01-01')->comment('入职时间');
            $table->date('entered_at')->default('1000-01-01')->comment('入住日期');
            $table->date('contract_start')->default('1000-01-01')->comment('劳动合同开始日');
            $table->date('contract_end')->default('1000-01-01')->comment('劳动合同结束日');
            $table->string('emergency_person', 4)->default('')->comment('紧急联系人');
            $table->string('emergency_phone', 13)->default('')->comment('紧急联系电话');
            $table->string('origin')->default('')->comment('籍贯');
            $table->string('spouse')->default('')->comment('配偶');
            $table->string('spouse_identify')->default('');
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
