<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Program;
use App\Models\ProgramCategory;
use App\Models\User;
use Illuminate\Support\Str;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all(); // pastikan sudah ada user untuk created_by

        $programs = [
            ['name' => 'MUIN (Mushola Indah)', 'category' => 'Dakwah'],
            ['name' => 'Qurban Bareng Wali', 'category' => 'Sosial'],
            ['name' => 'Ramadhan Bareng Wali', 'category' => 'Sosial'],
            ['name' => 'Salami School', 'category' => 'Pendidikan'],
            ['name' => 'Sunatan Massal', 'category' => 'Sosial'],
            ['name' => 'Tanggap Bencana', 'category' => 'Kemanusiaan'],
            ['name' => 'Santunan Yatim & Dhuafa', 'category' => 'Sosial'],
            ['name' => 'WaliCare Peduli Palestina', 'category' => 'Kemanusiaan'],
        ];

        foreach ($programs as $prog) {
            $category = ProgramCategory::where('name', $prog['category'])->first();

            if ($category) {
                Program::create([
                    'category_id' => $category->id,
                    'created_by' => $users->random()->id ?? null,
                    'title' => $prog['name'],
                    'slug' => Str::slug($prog['name']),
                    'summary' => 'Program ' . $prog['name'] . ' untuk ' . $prog['category'],
                    'description' => 'Deskripsi lengkap program ' . $prog['name'] . ' yang termasuk kategori ' . $prog['category'],
                    'target_amount' => 10000000,
                    'collected_amount' => 0,
                    'status' => 'active',
                    'start_date' => now()->format('Y-m-d'),
                    'end_date' => now()->addMonth()->format('Y-m-d'),
                    'location' => 'Cianjur',
                    'is_featured' => false,
                ]);
            }
        }
    }
}
