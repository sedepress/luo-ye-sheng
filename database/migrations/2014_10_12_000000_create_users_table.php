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
            $table->string('nickname')->default('')->comment('昵称');
            $table->string('openid', 50)->unique();
            $table->tinyInteger('character_level', false, true)->default(1)->comment('人物等级');
            $table->tinyInteger('mining_level', false, true)->default(1)->comment('挖矿等级');
            $table->tinyInteger('forging_level', false, true)->default(1)->comment('锻造等级');
            $table->integer('fatigue_value', false, true)->default(20)->comment('疲劳值');
            $table->integer('lucky_value', false, true)->default(0)->comment('幸运值');
            $table->integer('manpower', false, true)->default(0)->comment('人力值');
            $table->integer('current_exp', false, true)->default(0)->comment('当前经验值');
            $table->integer('history_exp', false, true)->default(0)->comment('历史经验值');
            $table->integer('current_gold', false, true)->default(0)->comment('当前金币');
            $table->string('invitation_code')->default('')->comment('邀请码');
            $table->integer('inv_num', false, true)->default(0)->comment('邀请人数');
            $table->integer('invite_people', false, true)->default(0)->comment('邀请人');
            $table->boolean('is_used_inv')->default(false)->comment('是否使用邀请码');
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
