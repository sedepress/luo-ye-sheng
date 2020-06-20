<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBattleScenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('battle_scenes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('minimum_level_limit')->comment('最低等级限制');
            $table->smallInteger('gold_lower', false, true)->comment('掉落金币下限');
            $table->smallInteger('gold_upper', false, true)->comment('掉落金币上限');
            $table->tinyInteger('probability', false, true)->default(0)->comment('掉落概率');
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
        Schema::dropIfExists('battle_scenes');
    }
}
