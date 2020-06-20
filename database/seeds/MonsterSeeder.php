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
        DB::table('monsters')->insert([
            'name'         => '一级怪物',
            'attack_lower' => 1,
            'attack_upper' => 4,
            'defense'      => 0,
            'speed'        => 0,
            'blood_volume' => 10,
            'exp'          => 5,
            'created_at'   => date('Y-m-d H:i:s', time()),
            'updated_at'   => date('Y-m-d H:i:s', time()),
        ]);

        DB::table('monsters')->insert([
            'name'         => '二级怪物',
            'attack_lower' => 4,
            'attack_upper' => 6,
            'defense'      => 1,
            'speed'        => 1,
            'blood_volume' => 20,
            'exp'          => 10,
            'created_at'   => date('Y-m-d H:i:s', time()),
            'updated_at'   => date('Y-m-d H:i:s', time()),
        ]);

        DB::table('monsters')->insert([
            'name'         => '三级怪物',
            'attack_lower' => 6,
            'attack_upper' => 10,
            'defense'      => 2,
            'speed'        => 2,
            'blood_volume' => 30,
            'exp'          => 15,
            'created_at'   => date('Y-m-d H:i:s', time()),
            'updated_at'   => date('Y-m-d H:i:s', time()),
        ]);

        DB::table('monsters')->insert([
            'name'         => '四级怪物',
            'attack_lower' => 10,
            'attack_upper' => 15,
            'defense'      => 3,
            'speed'        => 3,
            'blood_volume' => 40,
            'exp'          => 25,
            'created_at'   => date('Y-m-d H:i:s', time()),
            'updated_at'   => date('Y-m-d H:i:s', time()),
        ]);

        DB::table('monsters')->insert([
            'name'         => '五级怪物',
            'attack_lower' => 15,
            'attack_upper' => 30,
            'defense'      => 5,
            'speed'        => 5,
            'blood_volume' => 100,
            'exp'          => 40,
            'created_at'   => date('Y-m-d H:i:s', time()),
            'updated_at'   => date('Y-m-d H:i:s', time()),
        ]);

        DB::table('monsters')->insert([
            'name'         => '六级怪物',
            'attack_lower' => 30,
            'attack_upper' => 50,
            'defense'      => 7,
            'speed'        => 7,
            'blood_volume' => 150,
            'exp'          => 70,
            'created_at'   => date('Y-m-d H:i:s', time()),
            'updated_at'   => date('Y-m-d H:i:s', time()),
        ]);

        DB::table('monsters')->insert([
            'name'         => '七级怪物',
            'attack_lower' => 50,
            'attack_upper' => 70,
            'defense'      => 9,
            'speed'        => 9,
            'blood_volume' => 200,
            'exp'          => 100,
            'created_at'   => date('Y-m-d H:i:s', time()),
            'updated_at'   => date('Y-m-d H:i:s', time()),
        ]);

        DB::table('monsters')->insert([
            'name'         => '八级怪物',
            'attack_lower' => 70,
            'attack_upper' => 100,
            'defense'      => 10,
            'speed'        => 10,
            'blood_volume' => 250,
            'exp'          => 130,
            'created_at'   => date('Y-m-d H:i:s', time()),
            'updated_at'   => date('Y-m-d H:i:s', time()),
        ]);

        DB::table('monsters')->insert([
            'name'         => '九级怪物',
            'attack_lower' => 100,
            'attack_upper' => 150,
            'defense'      => 12,
            'speed'        => 12,
            'blood_volume' => 350,
            'exp'          => 160,
            'created_at'   => date('Y-m-d H:i:s', time()),
            'updated_at'   => date('Y-m-d H:i:s', time()),
        ]);

        DB::table('monsters')->insert([
            'name'         => '十级怪物',
            'attack_lower' => 150,
            'attack_upper' => 250,
            'defense'      => 15,
            'speed'        => 15,
            'blood_volume' => 500,
            'exp'          => 250,
            'created_at'   => date('Y-m-d H:i:s', time()),
            'updated_at'   => date('Y-m-d H:i:s', time()),
        ]);
    }
}
