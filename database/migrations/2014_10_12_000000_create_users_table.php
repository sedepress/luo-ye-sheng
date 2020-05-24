<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('external_id', false, true)->comment('对外编号');
            $table->string('nickname')->comment('昵称');
            $table->tinyInteger('character_level', false, true)->default(1)->comment('人物等级');
            $table->tinyInteger('mining_level', false, true)->default(1)->comment('挖矿等级');
            $table->tinyInteger('forging_level', false, true)->default(1)->comment('锻造等级');
            $table->integer('fatigue_value', false, true)->default(0)->comment('疲劳值');
            $table->integer('lucky_value', false, true)->default(0)->comment('幸运值');
            $table->integer('manpower', false, true)->default(0)->comment('人力值');
            $table->integer('current_exp', false, true)->default(0)->comment('当前经验值');
            $table->integer('history_exp', false, true)->default(0)->comment('历史经验值');
            $table->integer('current_gold', false, true)->default(0)->comment('当前金币');
            $table->string('invitation_code')->comment('邀请码');
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
        Schema::dropIfExists('users');
    }
}
