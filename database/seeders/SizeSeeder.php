<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Size;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $sizes = [
            'Non définie', 'Universelle', '0 mois', '3 mois', '6 mois', '9 mois', '12 mois', '18 mois', '24 mois',
            '3 ans', '4 ans', '5 ans', '6 ans', '7 ans', '8 ans', '10 ans', '12 ans', '14 ans', '16 ans', '18 ans', 'XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'
        ];
        foreach($sizes as $size){
            Size::create([
                'sizeName' => $size
            ]);
        }
        
    }
}
