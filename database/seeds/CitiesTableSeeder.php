<?php

use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::select('INSERT INTO cities(name, state_id, created_at, updated_at) VALUES (?, ?, ?, ?)', ['Helsinki', 1, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
    }
}
