<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan sudah ada kategori, kalau belum buat dulu
        if (Category::count() === 0) {
            Category::insert([
                ['name' => 'Bantuan Sosial', 'slug' => 'bantuan-sosial', 'description' => 'Program bantuan bagi masyarakat yang membutuhkan'],
                ['name' => 'Pendidikan', 'slug' => 'pendidikan', 'description' => 'Program peningkatan pendidikan dan beasiswa'],
                ['name' => 'Kesehatan', 'slug' => 'kesehatan', 'description' => 'Program untuk pelayanan kesehatan masyarakat'],
            ]);
        }

        $categories = Category::all();

        // Data event contoh
        $eventsData = [
            [
                'title' => 'Bakti Sosial untuk Korban Banjir Cianjur',
                'description' => 'Kegiatan bantuan sosial untuk membantu warga terdampak banjir di wilayah Cianjur.',
                'location' => 'Cianjur, Jawa Barat',
                'start_date' => now()->subDays(5),
                'end_date' => now()->addDays(5),
                'image' => 'events/baek.jpg',
                'is_active' => true,
            ],
            [
                'title' => 'Program Beasiswa Siswa Berprestasi',
                'description' => 'Memberikan dukungan pendidikan bagi siswa berprestasi dari keluarga kurang mampu.',
                'location' => 'SMKN 1 Cianjur',
                'start_date' => now()->addDays(10),
                'end_date' => now()->addDays(30),
                'image' => 'events/songmin.jpg',
                'is_active' => true,
            ],
            [
                'title' => 'Donor Darah PMI Cianjur',
                'description' => 'Kegiatan donor darah bersama PMI Kabupaten Cianjur untuk meningkatkan stok darah daerah.',
                'location' => 'Kantor PMI Cianjur',
                'start_date' => now()->addDays(2),
                'end_date' => now()->addDays(2),
                'image' => 'events/baek.jpg',
                'is_active' => true,
            ],
            [
                'title' => 'Pelatihan Kesehatan Dasar Relawan PMI',
                'description' => 'Pelatihan pertolongan pertama bagi relawan PMI untuk kesiapan tanggap darurat.',
                'location' => 'Markas PMI Cianjur',
                'start_date' => now()->addDays(7),
                'end_date' => now()->addDays(9),
                'image' => 'events/songmin.jpg',
                'is_active' => true,
            ],
        ];

        foreach ($eventsData as $data) {
            Event::create([
                'category_id' => $categories->random()->id,
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'description' => $data['description'],
                'location' => $data['location'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'image' => $data['image'],
                'is_active' => $data['is_active'],
            ]);
        }
    }
}
