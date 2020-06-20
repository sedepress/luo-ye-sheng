<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->smallInteger('lower', false, true)->default(0)->comment('装备属性下限');
            $table->smallInteger('upper', false, true)->default(0)->comment('装备属性上限');
            $table->tinyInteger('type', false, true)->comment('装备类型(1武器2衣服3鞋子)');
            $table->integer('price', false, true)->comment('单价');
            $table->string('price_type')->comment('价格类型');
            $table->integer('sales_num', false, true)->comment('出售数量');
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
        Schema::dropIfExists('equipments');
    }
}
