<?php

use Illuminate\Database\Seeder;

class MonsterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('battle_scenes')->insert([
            'name'         => '一级怪物',
            'attack_lower' => 1,
            'attack_upper' => 4,
            'defense'      => 0,
            'speed'        => 0,
            'blood_volume' => 10,
            'created_at'   => date('Y-m-d H:i:s', time()),
            'updated_at'   => date('Y-m-d H:i:s', time()),
        ]);

        DB::table('battle_scenes')->insert([
            'name'         => '二级怪物',
            'attack_lower' => 4,
            'attack_upper' => 6,
            'defense'      => 1,
            'speed'        => 1,
            'blood_volume' => 20,
            'created_at'   => date('Y-m-d H:i:s', time()),
            'updated_at'   => date('Y-m-d H:i:s', time()),
        ]);

        DB::table('battle_scenes')->insert([
            'name'         => '三级怪物',
            'attack_lower' => 6,
            'attack_upper' => 10,
            'defense'      => 2,
            'speed'        => 2,
            'blood_volume' => 30,
            'created_at'   => date('Y-m-d H:i:s', time()),
            'updated_at'   => date('Y-m-d H:i:s', time()),
        ]);

        DB::table('battle_scenes')->insert([
            'name'         => '四级怪物',
            'attack_lower' => 10,
            'attack_upper' => 15,
            'defense'      => 3,
            'speed'        => 3,
            'blood_volume' => 40,
            'created_at'   => date('Y-m-d H:i:s', time()),
            'updated_at'   => date('Y-m-d H:i:s', time()),
        ]);

        DB::table('battle_scenes')->insert([
            'name'         => '五级怪物',
            'attack_lower' => 15,
            'attack_upper' => 30,
            'defense'      => 5,
            'speed'        => 5,
            'blood_volume' => 100,
            'created_at'   => date('Y-m-d H:i:s', time()),
            'updated_at'   => date('Y-m-d H:i:s', time()),
        ]);

        DB::table('battle_scenes')->insert([
            'name'         => '六级怪物',
            'attack_lower' => 30,
            'attack_upper' => 50,
            'defense'      => 7,
            'speed'        => 7,
            'blood_volume' => 150,
            'created_at'   => date('Y-m-d H:i:s', time()),
            'updated_at'   => date('Y-m-d H:i:s', time()),
        ]);

        DB::table('battle_scenes')->insert([
            'name'         => '七级怪物',
            'attack_lower' => 50,
            'attack_upper' => 70,
            'defense'      => 9,
            'speed'        => 9,
            'blood_volume' => 200,
            'created_at'   => date('Y-m-d H:i:s', time()),
            'updated_at'   => date('Y-m-d H:i:s', time()),
        ]);

        DB::table('battle_scenes')->insert([
            'name'         => '一级怪物',
            'attack_lower' => 1,
            'attack_upper' => 4,
            'defense'      => 0,
            'speed'        => 0,
            'blood_volume' => 10,
            'created_at'   => date('Y-m-d H:i:s', time()),
            'updated_at'   => date('Y-m-d H:i:s', time()),
        ]);

        DB::table('battle_scenes')->insert([
            'name'         => '一级怪物',
            'attack_lower' => 1,
            'attack_upper' => 4,
            'defense'      => 0,
            'speed'        => 0,
            'blood_volume' => 10,
            'created_at'   => date('Y-m-d H:i:s', time()),
            'updated_at'   => date('Y-m-d H:i:s', time()),
        ]);

        DB::table('battle_scenes')->insert([
            'name'         => '一级怪物',
            'attack_lower' => 1,
            'attack_upper' => 4,
            'defense'      => 0,
            'speed'        => 0,
            'blood_volume' => 10,
            'created_at'   => date('Y-m-d H:i:s', time()),
            'updated_at'   => date('Y-m-d H:i:s', time()),
        ]);
    }
}
