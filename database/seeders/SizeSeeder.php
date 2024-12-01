<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL', 28,30,32,34,36,38,40,42,44,45];

    foreach ($sizes as $size) {
        Size::create(['name' => $size]);
    }
    }
}
