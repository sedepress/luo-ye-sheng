<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id', false, true);
            $table->integer('hero_id', false, true)->default(1);
            $table->tinyInteger('force', false, true)->default(5)->comment('武力');
            $table->tinyInteger('intelligence', false, true)->default(5)->comment('智力');
            $table->tinyInteger('defence', false, true)->default(1)->comment('防御');
            $table->tinyInteger('speed', false, true)->default(1)->comment('速度');
            $table->boolean('is_equip_weapon')->default(0)->comment('是否装备武器');
            $table->boolean('is_equip_armor')->default(0)->comment('是否装备衣服');
            $table->boolean('is_equip_shoes')->default(0)->comment('是否装备鞋子');
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
        Schema::dropIfExists('user_profiles');
    }
}
