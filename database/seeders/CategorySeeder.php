<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    \App\Models\Category::insert([
        ['user_id' => 1, 'name' => 'Makanan'],
        ['user_id' => 1, 'name' => 'Transportasi'],
        ['user_id' => 1, 'name' => 'Gaji'],
        ['user_id' => 1, 'name' => 'Hiburan'],
    ]);
}
}
