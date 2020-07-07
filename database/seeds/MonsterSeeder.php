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
        $lower = [6, 11, 16, 21, 55, 76, 102, 148, 214, 335];
        $upper = [10, 15, 20, 25, 75, 100, 130, 180, 250, 375];
        $defense = [0, 0, 5, 5, 15, 20, 25, 30, 35, 40];
        $speed = [6, 12, 18, 24, 30, 42, 57, 84, 123, 195];
        $blood = [10, 20, 30, 40, 50, 100, 150, 200, 250, 300];
        $exp = [5, 10, 15, 20, 40, 70, 110, 160, 220, 300];
        for ($i = 0; $i < 10; $i++) {
            DB::table('monsters')->insert([
                'name'         => ($i + 1) . '级怪物',
                'attack_lower' => $lower[$i],
                'attack_upper' => $upper[$i],
                'defense'      => $defense[$i],
                'speed'        => $speed[$i],
                'blood_volume' => $blood[$i],
                'exp'          => $exp[$i],
                'created_at'   => date('Y-m-d H:i:s', time()),
                'updated_at'   => date('Y-m-d H:i:s', time()),
            ]);
        }
    }
}
