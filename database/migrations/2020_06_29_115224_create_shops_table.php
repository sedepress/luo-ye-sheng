<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('shop_type', false, true)->default(1)->comment('商品类型1系统商品2玩家出售');
            $table->tinyInteger('type', false, true)->comment('1武器2护甲3鞋子4腰带5锄头6锻造炉7矿石8药品');
            $table->integer('lower', false, true)->default(0)->comment('装备属性下限');
            $table->integer('upper', false, true)->default(0)->comment('装备属性上限');
            $table->tinyInteger('price_type', false, true)->default(1)->comment('1人力值 2金币');
            $table->boolean('on_sale')->default(true);
            $table->tinyInteger('rating', false, true);
            $table->integer('price', false, true);
            $table->integer('stock', false, true)->default(0);
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
        Schema::dropIfExists('shops');
    }
}
