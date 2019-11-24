<?php

use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::select('INSERT INTO languages(name, created_at, updated_at) VALUES (?, ?, ?)', ['en', date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
        DB::select('INSERT INTO languages(name, created_at, updated_at) VALUES (?, ?, ?)', ['fi', date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
        DB::select('INSERT INTO languages(name, created_at, updated_at) VALUES (?, ?, ?)', ['es', date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
    }
}
