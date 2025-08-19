<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            ['name'=>'Gaji','type'=>'income'],
            ['name'=>'Hadiah','type'=>'income'],
            ['name'=>'Makan','type'=>'expense'],
            ['name'=>'Transport','type'=>'expense'],
            ['name'=>'Belanja','type'=>'expense'],
            ['name'=>'Tagihan','type'=>'expense'],
        ];
        foreach($defaults as $c){
            Category::create($c); // user_id null → global
        }
    }
}
