<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
        $colors = [
            'White', 'Black', 'Gray', 'Beige', 'Brown', 'Red', 'Blue', 
            'Yellow', 'Green', 'Orange', 'Purple', 'Pink', 'Turquoise', 
            'Navy Blue', 'Gold', 'Silver', 'Coral','Olive Green',
        ];
        
        foreach ($colors as $color) {
            Color::create(['name' => $color]);
        }
    }
}
