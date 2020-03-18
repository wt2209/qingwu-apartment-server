<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('area_id')->default(0);
            $table->unsignedBigInteger('category_id')->default(0);
            $table->string('title', 10)->default('')->index();
            $table->string('building', 5)->default('');
            $table->string('unit')->default('');
            $table->decimal('rent')->default(0)->comment('默认租金');
            $table->integer('number')->default(1)->comment('房间最大人数');
            $table->string('remark')->default('');
            $table->softDeletes('deleted_at', 0);
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
        Schema::dropIfExists('rooms');
    }
}
