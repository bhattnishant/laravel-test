<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AttributeTableSeeder::class);
		$this->call(StockStatusTableSeeder::class);		
    }
}

class AttributeTableSeeder extends Seeder {

    public function run()
    {
        DB::table('attributes')->delete();

        DB::table('attributes')->insert(['name' => 'type']);
		DB::table('attributes')->insert(['name' => 'size']);
		DB::table('attributes')->insert(['name' => 'color']);
    }

}

class StockStatusTableSeeder extends Seeder {

    public function run()
    {
        DB::table('stock_statuses')->delete();

        DB::table('stock_statuses')->insert(['name' => 'in stock']);
		DB::table('stock_statuses')->insert(['name' => 'Pre-Order']);
		DB::table('stock_statuses')->insert(['name' => 'out of stock']);
		DB::table('stock_statuses')->insert(['name' => '2-3 Days']);	
    }

}