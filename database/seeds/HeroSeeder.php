<?php

use Illuminate\Database\Seeder;

class HeroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('heroes')->insert([
            'name'                => '小兵',
            'force_growth'        => 5,
            'intelligence_growth' => 5,
            'defence_growth'      => 1,
            'speed_growth'        => 1,
            'blood_growth'        => 20,
        ]);
    }
}
