<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMiningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('minings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('minimum_level_limit', false, true)->comment('最低道具等级限制');
            $table->tinyInteger('black_iron_probability', false, true)->comment('黑铁矿石');
            $table->tinyInteger('bronze_probability', false, true)->comment('青铜矿石');
            $table->tinyInteger('iron_probability', false, true)->comment('铁矿石');
            $table->tinyInteger('silver_probability', false, true)->comment('银矿石');
            $table->tinyInteger('gold_probability', false, true)->comment('金矿石');
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
        Schema::dropIfExists('minings');
    }
}
