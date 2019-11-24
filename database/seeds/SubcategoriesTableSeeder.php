<?php

use Illuminate\Database\Seeder;

class SubcategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::select('INSERT INTO subcategories(name, category_id, created_at, updated_at) VALUES (?, ?, ?, ?)', ['Soccer', 3, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
        DB::select('INSERT INTO subcategories(name, category_id, created_at, updated_at) VALUES (?, ?, ?, ?)', ['Electrical Engineering', 2, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
        DB::select('INSERT INTO subcategories(name, category_id, created_at, updated_at) VALUES (?, ?, ?, ?)', ['Foreman', 1, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
    }
}
