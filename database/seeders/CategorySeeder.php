<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Bantuan Sosial', 'slug' => 'bantuan-sosial', 'description' => 'Program bantuan bagi masyarakat yang membutuhkan'],
            ['name' => 'Pendidikan', 'slug' => 'pendidikan', 'description' => 'Program yang berfokus pada pendidikan dan pelatihan'],
            ['name' => 'Kesehatan', 'slug' => 'kesehatan', 'description' => 'Program kesehatan masyarakat dan donor darah'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
