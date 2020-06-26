<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('area_id')->default(0);
            $table->string('type', 12)->default('')->comment('取值：person|company|functional');
            $table->uuid('category_id')->default(0);
            $table->uuid('room_id')->default(0);
            $table->uuid('person_id')->default(0);
            $table->uuid('company_id')->default(0);
            $table->string('functional_title')->default('')->comment('功能性用房的标题');
            $table->uuid('charge_rule_id')->default(0);
            $table->date('charged_to')->nullable()->comment('已缴费至');
            $table->date('record_at')->default('1000-01-01')->comment('记录时间（入住时间）');
            $table->date('rent_start')->default('1000-01-01')->comment('入住期限开始日期');
            $table->date('rent_end')->default('1000-01-01')->comment('入住期限结束日期');
            $table->json('proof_files')->nullable();
            $table->integer('electric_start_base')->nullable();
            $table->integer('electric_end_base')->nullable();
            $table->integer('water_start_base')->nullable();
            $table->integer('water_end_base')->nullable();
            $table->string('status', 10)->default('living')->comment('取值：living|quitted|moved');
            $table->unsignedBigInteger('to_room')->default(0)->comment('调房后的房间id');
            $table->softDeletes('deleted_at');
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
        Schema::dropIfExists('records');
    }
}
