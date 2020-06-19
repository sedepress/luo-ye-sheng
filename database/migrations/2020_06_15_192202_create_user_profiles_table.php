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
            $table->tinyInteger('character_level', false, true)->default(1)->comment('人物等级');
            $table->tinyInteger('mining_level', false, true)->default(1)->comment('挖矿等级');
            $table->tinyInteger('forging_level', false, true)->default(1)->comment('锻造等级');
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
        Schema::dropIfExists('user_profiles');
    }
}
