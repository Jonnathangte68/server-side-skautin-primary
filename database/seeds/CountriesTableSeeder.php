<?php

use Illuminate\Database\Seeder;
use App\Utils\Logger;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::select('INSERT INTO countries(name, created_at, updated_at) VALUES (?, ?, ?)', ['Finland', date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
    }
}
