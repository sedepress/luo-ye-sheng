<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHerosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('heroes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('attack_growth', false, true)->default(5)->comment('攻击成长');
            $table->tinyInteger('intelligence_growth', false, true)->default(5)->comment('魔法成长');
            $table->tinyInteger('defence_growth', false, true)->default(1)->comment('防御成长');
            $table->tinyInteger('speed_growth', false, true)->default(1)->comment('速度成长');
            $table->tinyInteger('blood_growth', false, true)->default(20)->comment('血量成长');
            $table->integer('sales_num', false, true)->default(0);
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
        Schema::dropIfExists('heroes');
    }
}
