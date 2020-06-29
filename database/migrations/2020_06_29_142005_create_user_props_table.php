<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPropsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_props', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->smallInteger('lower', false, true)->default(0)->comment('装备属性下限');
            $table->smallInteger('upper', false, true)->default(0)->comment('装备属性上限');
            $table->tinyInteger('type', false, true)->comment('1武器2护甲3鞋子4锄头5锻造炉6矿石7药品');
            $table->boolean('is_equip')->default(false);
            $table->integer('remaining_usage', false, true)->default(0)->comment('剩余使用量（针对非装备道具）');
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('user_props');
    }
}
