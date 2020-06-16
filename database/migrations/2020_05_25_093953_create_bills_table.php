<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('area_id');
            $table->string('type')->comment('person|company|other');
            $table->string('way')->comment('收费方式:before|after');
            $table->string('location')->comment('房间号/位置');
            $table->string('name')->nullable()->comment('姓名或公司名');
            $table->string('title')->comment('费用类型名称');
            $table->boolean('turn_in')->default(true);
            $table->decimal('money', 10, 2);
            $table->string('description')->nullable()->comment('费用说明');
            $table->decimal('late_base', 10, 2)->nullable()->comment('滞纳金基数');
            $table->decimal('late_rate', 4, 2)->nullable()->comment('滞纳金费率');
            $table->date('late_date')->nullable()->comment('滞纳金开始计算日期');
            $table->date('should_charge_at')->comment('最晚应缴费日期');
            $table->date('charged_at')->nullable()->comment('交费时间');
            $table->boolean('is_refund')->default(false)->comment('是否是退费');
            $table->boolean('auto_generate')->default(false)->comment('标识是否是自动生成的费用');
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
        Schema::dropIfExists('bills');
    }
}
