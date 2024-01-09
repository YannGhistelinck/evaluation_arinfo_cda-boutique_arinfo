<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OrderStatus;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderStatus::create([
            'orderStatus' => 'draft'
        ]);
        
        OrderStatus::create([
            'orderStatus' => 'in preparation'
        ]);
        
        OrderStatus::create([
            'orderStatus' => 'sent'
        ]);
        
        OrderStatus::create([
            'orderStatus' => 'delivered'
        ]);
    }
}
