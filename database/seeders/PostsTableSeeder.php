<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        
        DB::table('posts')->insert([
            [
                'title' => 'Professional Teacher Training',
                'subtitle' => 'Empowering Educators in Belu',
                'slug' => 'professional-teacher-training',
                'description' => 'On October 30–31, 2023, a professional training program for school teachers was successfully conducted in Belu Regency.',
                'date' => '2024-04-11',
                'images' => json_encode([
                    'posts/1751588659_q1zVOuC9Dl.jpeg',
                    'posts/1751588659_EiEmSB69Vq.jpeg',
                    'posts/1751588659_QbLZdGCZb1.jpeg',
                    'posts/1751588659_nyjIOdkL4c.jpeg',
                    'posts/1751588659_aZwmqxpnZ4.jpeg',
                    'posts/1751588659_K0pWdPsrRk.jpeg',
                    'posts/1751588659_O1qkJmOAsS.jpeg'
                ]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Water Tank Installation',
                'subtitle' => 'Construction of water tanks with a capacity of 15,000 liters per family',
                'slug' => 'water-tank-installation',
                'description' => 'Construction of 15,000 liter capacity water tanks in Belu Regency, NTT.',
                'date' => '2024-04-12',
                'images' => json_encode([
                    'posts/1751588825_lzGAAE3S5C.jpeg',
                    'posts/1751588825_ZaHtKW9wCZ.jpeg',
                    'posts/1751588825_8mE1NScwUG.jpeg',
                    'posts/1751588825_LgWYmBGJn8.jpeg',
                    'posts/1751588825_2za8dsJB0l.jpeg'
                ]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
} 