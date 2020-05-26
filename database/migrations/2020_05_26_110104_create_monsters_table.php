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
            $table->tinyInteger('attack_lower')->comment('攻击下限');
            $table->tinyInteger('attack_upper')->comment('攻击上限');
            $table->tinyInteger('defense')->comment('防御');
            $table->tinyInteger('speed')->comment('速度');
            $table->smallInteger('blood_volume')->comment('血量');
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
