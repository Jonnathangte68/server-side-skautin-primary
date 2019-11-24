<?php

use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::select('INSERT INTO states(name, country_id, created_at, updated_at) VALUES (?, ?, ?, ?)', ['Uusimaa', 1, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
    }
}
