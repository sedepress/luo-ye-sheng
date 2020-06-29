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
            $table->integer('fatigue_value', false, true)->default(20)->comment('疲劳值');
            $table->integer('lucky_value', false, true)->default(0)->comment('幸运值');
            $table->integer('manpower', false, true)->default(0)->comment('人力值');
            $table->smallInteger('current_blood_volume')->default(20)->comment('当前血量');
            $table->smallInteger('total_blood_volume')->default(20)->comment('总血量');
            $table->integer('current_exp', false, true)->default(0)->comment('当前经验值');
            $table->integer('history_exp', false, true)->default(0)->comment('历史经验值');
            $table->integer('current_gold', false, true)->default(0)->comment('当前金币');
            $table->tinyInteger('force', false, true)->default(5)->comment('武力');
            $table->tinyInteger('intelligence', false, true)->default(5)->comment('智力');
            $table->tinyInteger('defence', false, true)->default(1)->comment('防御');
            $table->tinyInteger('speed', false, true)->default(1)->comment('速度');
            $table->boolean('equip_weapon_id')->default(0)->comment('是否装备武器');
            $table->boolean('equip_armor_id')->default(0)->comment('是否装备衣服');
            $table->boolean('equip_shoes_id')->default(0)->comment('是否装备鞋子');
            $table->boolean('equip_drup_id')->default(0)->comment('是否装备药品');
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
