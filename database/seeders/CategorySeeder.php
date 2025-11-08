<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Bantuan Sosial', 'slug' => 'bantuan-sosial'],
            ['name' => 'Pendidikan', 'slug' => 'pendidikan', ],
            ['name' => 'Kesehatan', 'slug' => 'kesehatan', ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
