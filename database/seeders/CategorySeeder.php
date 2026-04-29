<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Wanita',    'slug' => 'wanita',    'description' => 'Koleksi fashion wanita modern'],
            ['name' => 'Pria',      'slug' => 'pria',      'description' => 'Koleksi fashion pria minimalis'],
            ['name' => 'Aksesoris', 'slug' => 'aksesoris', 'description' => 'Aksesoris premium untuk melengkapi penampilan'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}
