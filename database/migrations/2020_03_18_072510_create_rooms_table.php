<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
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
            $table->uuid('id');
            $table->uuid('area_id');
            $table->uuid('category_id');
            $table->uuid('charge_rule_id');
            $table->string('title', 10)->default('')->index();
            $table->string('building', 5)->default('');
            $table->string('unit')->default('');
            $table->integer('number')->default(1)->comment('房间最大人数');
            $table->string('remark')->nullable();
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
