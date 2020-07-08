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
            $table->string('nickname')->unique()->nullable()->comment('昵称');
            $table->string('openid', 50)->unique();
            $table->integer('fatigue_value', false, true)->default(10)->comment('疲劳值');
            $table->integer('lucky_value', false, true)->default(0)->comment('幸运值');
            $table->integer('manpower', false, true)->default(0)->comment('人力值');
            $table->integer('current_character_exp', false, true)->default(0)->comment('当前人物等级经验值');
            $table->integer('history_character_exp', false, true)->default(0)->comment('历史人物等级经验值');
            $table->integer('current_mining_exp', false, true)->default(0)->comment('当前挖矿等级经验值');
            $table->integer('history_mining_exp', false, true)->default(0)->comment('历史挖矿等级经验值');
            $table->integer('current_forging_exp', false, true)->default(0)->comment('当前锻造等级经验值');
            $table->integer('history_forging_exp', false, true)->default(0)->comment('历史锻造等级经验值');
            $table->integer('current_gold', false, true)->default(0)->comment('当前金币');
            $table->integer('current_blood_volume')->default(20)->comment('当前血量');
            $table->integer('total_blood_volume')->default(20)->comment('总血量');
            $table->integer('attack_lower', false, true)->default(5)->comment('攻击上限');
            $table->integer('attack_upper', false, true)->default(5)->comment('攻击下限');
            $table->integer('intelligence', false, true)->default(5)->comment('魔法');
            $table->integer('defence', false, true)->default(5)->comment('防御');
            $table->integer('speed', false, true)->default(3)->comment('速度');
            $table->integer('extra_attack_lower', false, true)->default(0)->comment('附加下限攻击');
            $table->integer('extra_attack_upper', false, true)->default(0)->comment('附加上限攻击');
            $table->integer('extra_intelligence', false, true)->default(0)->comment('附加魔法');
            $table->integer('extra_defence', false, true)->default(0)->comment('附加防御');
            $table->integer('extra_speed', false, true)->default(0)->comment('附加速度');
            $table->integer('extra_blood', false, true)->default(0)->comment('附加血量');
            $table->integer('equip_weapon_id')->default(0)->comment('装备武器id');
            $table->integer('equip_armor_id')->default(0)->comment('装备衣服id');
            $table->integer('equip_shoes_id')->default(0)->comment('装备鞋子id');
            $table->integer('equip_belt_id')->default(0)->comment('装备腰带id');
            $table->integer('equip_hoe_id')->default(0)->comment('装备锄头id');
            $table->integer('equip_forging_id')->default(0)->comment('装备锻造炉id');
            $table->integer('equip_drup_id')->default(0)->comment('装备药品id');
            $table->integer('hero_id', false, true)->default(1);
            $table->tinyInteger('character_level', false, true)->default(1)->comment('人物等级');
            $table->tinyInteger('mining_level', false, true)->default(1)->comment('挖矿等级');
            $table->tinyInteger('forging_level', false, true)->default(1)->comment('锻造等级');
            $table->string('invitation_code')->default('')->comment('邀请码');
            $table->integer('inv_num', false, true)->default(0)->comment('邀请人数');
            $table->integer('invite_people', false, true)->default(0)->comment('邀请人');
            $table->boolean('is_used_inv')->default(false)->comment('是否使用邀请码');
            $table->boolean('is_subscribe')->default(true)->comment('是否关注公众号');
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
