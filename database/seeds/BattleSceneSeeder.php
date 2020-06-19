<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BattleSceneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('battle_scenes')->insert([
            'name' => '一层洞穴',
            'minimum_level_limit' => 1,
            'gold_lower' => 1,
            'gold_upper' => 10,
            'probability' => 10,
            'created_at'  => date('Y-m-d H:i:s', time()),
            'updated_at'  => date('Y-m-d H:i:s', time()),
        ]);

        DB::table('battle_scenes')->insert([
            'name' => '二层洞穴',
            'minimum_level_limit' => 1,
            'gold_lower' => 5,
            'gold_upper' => 15,
            'probability' => 10,
            'created_at'  => date('Y-m-d H:i:s', time()),
            'updated_at'  => date('Y-m-d H:i:s', time()),
        ]);

        DB::table('battle_scenes')->insert([
            'name' => '三层洞穴',
            'minimum_level_limit' => 1,
            'gold_lower' => 10,
            'gold_upper' => 20,
            'probability' => 10,
            'created_at'  => date('Y-m-d H:i:s', time()),
            'updated_at'  => date('Y-m-d H:i:s', time()),
        ]);

        DB::table('battle_scenes')->insert([
            'name' => '四层洞穴',
            'minimum_level_limit' => 2,
            'gold_lower' => 15,
            'gold_upper' => 25,
            'probability' => 10,
            'created_at'  => date('Y-m-d H:i:s', time()),
            'updated_at'  => date('Y-m-d H:i:s', time()),
        ]);

        DB::table('battle_scenes')->insert([
            'name' => '五层洞穴',
            'minimum_level_limit' => 4,
            'gold_lower' => 25,
            'gold_upper' => 50,
            'probability' => 10,
            'created_at'  => date('Y-m-d H:i:s', time()),
            'updated_at'  => date('Y-m-d H:i:s', time()),
        ]);

        DB::table('battle_scenes')->insert([
            'name' => '六层洞穴',
            'minimum_level_limit' => 5,
            'gold_lower' => 50,
            'gold_upper' => 75,
            'probability' => 10,
            'created_at'  => date('Y-m-d H:i:s', time()),
            'updated_at'  => date('Y-m-d H:i:s', time()),
        ]);

        DB::table('battle_scenes')->insert([
            'name' => '七层洞穴',
            'minimum_level_limit' => 5,
            'gold_lower' => 75,
            'gold_upper' => 100,
            'probability' => 10,
            'created_at'  => date('Y-m-d H:i:s', time()),
            'updated_at'  => date('Y-m-d H:i:s', time()),
        ]);

        DB::table('battle_scenes')->insert([
            'name' => '八层洞穴',
            'minimum_level_limit' => 5,
            'gold_lower' => 100,
            'gold_upper' => 150,
            'probability' => 10,
            'created_at'  => date('Y-m-d H:i:s', time()),
            'updated_at'  => date('Y-m-d H:i:s', time()),
        ]);

        DB::table('battle_scenes')->insert([
            'name' => '九层洞穴',
            'minimum_level_limit' => 5,
            'gold_lower' => 150,
            'gold_upper' => 200,
            'probability' => 10,
            'created_at'  => date('Y-m-d H:i:s', time()),
            'updated_at'  => date('Y-m-d H:i:s', time()),
        ]);

        DB::table('battle_scenes')->insert([
            'name' => '十层洞穴',
            'minimum_level_limit' => 5,
            'gold_lower' => 200,
            'gold_upper' => 500,
            'probability' => 10,
            'created_at'  => date('Y-m-d H:i:s', time()),
            'updated_at'  => date('Y-m-d H:i:s', time()),
        ]);
    }
}
