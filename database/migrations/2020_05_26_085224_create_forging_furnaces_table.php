<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForgingFurnacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forging_furnaces', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('minimum_level_limit', false, true)->comment('最低道具等级限制');
            $table->tinyInteger('probability', false, true)->default(100)->comment('概率');
            $table->tinyInteger('black_iron', false, true)->comment('黑铁矿石');
            $table->tinyInteger('bronze', false, true)->comment('青铜矿石');
            $table->tinyInteger('iron', false, true)->comment('铁矿石');
            $table->tinyInteger('silver', false, true)->comment('银矿石');
            $table->tinyInteger('gold', false, true)->comment('金矿石');
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
        Schema::dropIfExists('forging_furnaces');
    }
}
