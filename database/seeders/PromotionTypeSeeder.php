<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PromotionType;

class PromotionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PromotionType::create([
            'promotionType' => '%'
        ]);
        
        PromotionType::create([
            'promotionType' => '€'
        ]);
    }
}
