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
            'probability' => 10
        ]);
    }
}
