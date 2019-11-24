<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::select('INSERT INTO categories(name, created_at, updated_at) VALUES (?, ?, ?)', ['Sports', date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
        DB::select('INSERT INTO categories(name, created_at, updated_at) VALUES (?, ?, ?)', ['Engineering', date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
        DB::select('INSERT INTO categories(name, created_at, updated_at) VALUES (?, ?, ?)', ['Construction', date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
    }
}
