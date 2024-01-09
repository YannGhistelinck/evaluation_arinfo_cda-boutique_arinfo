<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'categoryName' => 'Hommes'
        ]);
        
        Category::create([
            'categoryName' => 'Femmes'
        ]);
        
        Category::create([
            'categoryName' => 'Enfants'
        ]);
        
        Category::create([
            'categoryName' => 'Accessoires'
        ]);
    }
}
