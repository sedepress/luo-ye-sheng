<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonstersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monsters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('attack_lower', false, true)->comment('攻击下限');
            $table->smallInteger('attack_upper', false, true)->comment('攻击上限');
            $table->tinyInteger('defense', false, true)->comment('防御');
            $table->tinyInteger('speed', false, true)->comment('速度');
            $table->smallInteger('blood_volume', false, true)->comment('血量');
            $table->tinyInteger('exp', false, true)->comment('经验值');
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
        Schema::dropIfExists('monsters');
    }
}
