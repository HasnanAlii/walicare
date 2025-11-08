<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramCategory;
use Illuminate\Support\Str;

class ProgramCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Dakwah', 'description' => 'Program berkaitan dengan kegiatan dakwah.'],
            ['name' => 'Sosial', 'description' => 'Program bantuan sosial masyarakat.'],
            ['name' => 'Pendidikan', 'description' => 'Program mendukung pendidikan anak dan dewasa.'],
            ['name' => 'Kemanusiaan', 'description' => 'Program bantuan kemanusiaan untuk yang membutuhkan.'],
        ];

        foreach ($categories as $cat) {
            ProgramCategory::create([
                'name' => $cat['name'],
                'slug' => Str::slug($cat['name']),
                'description' => $cat['description'],
            ]);
        }
    }
}
