<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('company_name')->default('');
            $table->string('manager', 4)->default('')->comment('管理员');
            $table->string('manager_phone', 13)->default('')->comment('管理员电话');
            $table->string('linkman', 4)->default('')->comment('日常联系人');
            $table->string('linkman_phone', 13)->default('')->comment('联系人电话');
            $table->date('entered_at')->default('1000-01-01')->comment('公司入住时间');
            $table->string('remark')->default('');
            $table->index('company_name');
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
