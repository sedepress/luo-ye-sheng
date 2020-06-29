<?php

use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lower1 = [1, 5, 10, 15, 20, 25, 30, 35, 40, 45];
        $upper1 = [5, 10, 15, 20, 25, 30, 35, 40, 45, 50];
        $price  = [1, 3, 8, 15, 25, 50, 100, 200, 500, 1000];
        for ($i = 1; $i < 11; $i++) {
            DB::table('shops')->insert([
                'name'       => $i.'级武器',
                'type'       => 1,
                'lower'      => $lower1[$i - 1],
                'upper'      => $upper1[$i - 1],
                'rating'     => $i,
                'price'      => $price[$i - 1],
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]);
        }

        $lower2 = [1, 3, 5, 8, 10, 15, 20, 30, 40, 50];
        $upper2 = [1, 3, 5, 8, 10, 15, 20, 30, 40, 50];
        for ($i = 1; $i < 11; $i++) {
            DB::table('shops')->insert([
                'name'       => $i.'级护甲',
                'type'       => 2,
                'lower'      => $lower2[$i - 1],
                'upper'      => $upper2[$i - 1],
                'rating'     => $i,
                'price'      => $price[$i - 1],
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]);
        }

        $lower3 = [1, 3, 5, 8, 10, 15, 20, 30, 40, 50];
        $upper3 = [1, 3, 5, 8, 10, 15, 20, 30, 40, 50];
        for ($i = 1; $i < 11; $i++) {
            DB::table('shops')->insert([
                'name'       => $i.'级鞋子',
                'type'       => 3,
                'lower'      => $lower3[$i - 1],
                'upper'      => $upper3[$i - 1],
                'rating'     => $i,
                'price'      => $price[$i - 1],
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]);
        }

        for ($i = 1; $i < 11; $i++) {
            DB::table('shops')->insert([
                'name'       => $i.'级锄头',
                'type'       => 4,
                'rating'     => $i,
                'price'      => $price[$i - 1],
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]);
        }

        for ($i = 1; $i < 11; $i++) {
            DB::table('shops')->insert([
                'name'       => $i.'级锻造炉',
                'type'       => 5,
                'rating'     => $i,
                'price'      => $price[$i - 1],
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]);
        }

        for ($i = 1; $i < 11; $i++) {
            DB::table('shops')->insert([
                'name'       => $i . '级矿石',
                'type'       => 6,
                'rating'     => $i,
                'price'      => $price[$i - 1],
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]);
        }

        $lower7 = [100, 300, 800, 1500, 2500];
        $price7 = [10, 30, 80, 150, 250];
        for ($i = 1; $i < 6; $i++) {
            DB::table('shops')->insert([
                'name'       => $i.'级红罗羹',
                'type'       => 7,
                'lower'      => $lower7[$i - 1],
                'upper'      => $lower7[$i - 1],
                'price_type' => 2,
                'rating'     => $i,
                'price'      => $price7[$i - 1],
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]);
        }

        $lower7 = [50000, 150000, 250000, 400000, 500000];
        $price7 = [10, 30, 50, 80, 100];
        for ($i = 6; $i < 11; $i++) {
            DB::table('shops')->insert([
                'name'       => $i.'级红罗羹',
                'type'       => 7,
                'lower'      => $lower7[$i - 6],
                'upper'      => $lower7[$i - 6],
                'price_type' => 2,
                'rating'     => $i,
                'price'      => $price7[$i - 6],
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]);
        }
    }
}