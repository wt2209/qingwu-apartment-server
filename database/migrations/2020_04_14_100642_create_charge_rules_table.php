<?php

use App\Models\ChargeRule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChargeRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charge_rules', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('title')->unique();
            $table->string('type')->default(ChargeRule::TYPE_PERSON)->comment('收费规则对应的类型');
            $table->string('way')->default(ChargeRule::WAY_BEFORE);
            // [['name'=>'租赁房租', 'fee'=>[600,700,800,900],'turn_in'=>true, 'rate'=>0.3]] (上交财务，滞纳金费率0.3%)
            $table->json('rule')->nullable();
            // 缴费间隔周期（月数）
            $table->unsignedInteger('period')->default(1);
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
        Schema::dropIfExists('charge_rules');
    }
}
