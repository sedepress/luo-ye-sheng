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
            $table->integer('user_id', false, true);
            $table->smallInteger('lower', false, true)->default(0)->comment('装备属性下限');
            $table->smallInteger('upper', false, true)->default(0)->comment('装备属性上限');
            $table->tinyInteger('rating', false, true);
            $table->tinyInteger('type', false, true)->comment('1武器2护甲3鞋子4腰带5锄头6锻造炉7矿石8药品');
            $table->integer('shop_id', false, true)->default(0);
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
