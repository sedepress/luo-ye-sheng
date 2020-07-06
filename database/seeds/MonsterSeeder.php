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
        $lower = [1, 4, 6, 10, 15, 30, 50, 70, 100, 150];
        $upper = [4, 6, 10, 15, 30, 50, 70, 100, 150, 250];
        $defense = [0, 1, 2, 3, 5, 7, 9, 10, 12, 15];
        $speed = [10, 20, 30, 40, 55, 70, 85, 100, 125, 150];
        $blood = [10, 20, 30, 40, 100, 150, 200, 250, 300, 350, 500];
        $exp = [5, 10, 15, 25, 40, 70, 100, 130, 160, 250];
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
