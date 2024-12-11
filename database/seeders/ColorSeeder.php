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
            'White' => ['en' => 'White', 'ar' => 'أبيض'],
            'Black' => ['en' => 'Black', 'ar' => 'أسود'],
            'Gray' => ['en' => 'Gray', 'ar' => 'رمادي'],
            'Beige' => ['en' => 'Beige', 'ar' => 'بيج'],
            'Brown' => ['en' => 'Brown', 'ar' => 'بني'],
            'Red' => ['en' => 'Red', 'ar' => 'أحمر'],
            'Blue' => ['en' => 'Blue', 'ar' => 'أزرق'],
            'Yellow' => ['en' => 'Yellow', 'ar' => 'أصفر'],
            'Green' => ['en' => 'Green', 'ar' => 'أخضر'],
            'Orange' => ['en' => 'Orange', 'ar' => 'برتقالي'],
            'Purple' => ['en' => 'Purple', 'ar' => 'بنفسجي'],
            'Pink' => ['en' => 'Pink', 'ar' => 'وردي'],
            'Turquoise' => ['en' => 'Turquoise', 'ar' => 'تركوازي'],
            'Navy Blue' => ['en' => 'Navy Blue', 'ar' => 'أزرق داكن'],
            'Gold' => ['en' => 'Gold', 'ar' => 'ذهبي'],
            'Silver' => ['en' => 'Silver', 'ar' => 'فضي'],
            'Coral' => ['en' => 'Coral', 'ar' => 'مرجاني'],
            'Olive Green' => ['en' => 'Olive Green', 'ar' => 'أخضر زيتوني'],
        ];
        
        foreach ($colors as $color => $translations) {
            Color::create(['name' => $translations]);
        }
        
    }
}
