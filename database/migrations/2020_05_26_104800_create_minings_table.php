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
            $table->tinyInteger('probability', false, true)->default(100)->comment('概率');
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
