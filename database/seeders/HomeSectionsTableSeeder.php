<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class HomeSectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        DB::table('home_sections')->insert([
            [
                'section_key' => 'about',
                'content' => '<p>The <strong><em>UNITED TIMOR DEVELOPMENT FOUNDATION (UTDF)</em></strong> is an Indonesian-based non-profit organization based in Atambua, Belu District, NTT. It implements development activities in West Timor and, starting in 2025, will extend these to Timor Leste (TLE).</p><p>In May 2025, UTDF received funding from the <strong>UNWG (United Nations Women\'s Guild)</strong> to build 7 ferro-cement water tanks and 7 disability-accessible toilets in Belu District, East Nusa Tenggara. To date, UTDF has established over <strong>120 water tanks</strong> and <strong>20 disability toilets</strong> extending into the poor outskirts of Dili, Timor L\'Este.</p>',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'section_key' => 'mission',
                'content' => '<p class="fst-italic mt-3 mb-3 px-2">"Poverty alleviation through community initiatives and innovations, <br>for and by the people in the sanitation, education, and agriculture sectors."</p>',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'section_key' => 'management',
                'content' => '[{"name":"Dr. Ria Gondowarsito","role":"Founder & Supervisor","photo":"assets\/99EZgzdU0offnQEnHmeNZ85pQJUatUxbLKRHlrte.jpg"},{"name":"John Naihati","role":"Head","photo":"assets\/4xMOpcxMjPIstKVCLAGF7gqtewemF3w694XfD9yF.jpg"},{"name":"Dr. Evert Y. Hosang","role":"Deputy Head","photo":"assets\/I70ahc416dCWTm8LmOzFDkYWcu0IKaEicWWTF6T4.jpg"},{"name":"Hubertina Niat","role":"Secretary","photo":"assets\/CzPwRTO6GhF2SZqJSBLzZWQo8q8WTwvLEnIfahC5.jpg"},{"name":"Vincent Wun","role":"Treasurer","photo":"assets\/gxjFU8LoRvo2wgpgbTncJhDZwnFGj3OtVC4TdTti.jpg"},{"name":"Aloysius Noya","role":"Technical Coordinator","photo":"assets\/15Fcxq1eKBZMMngVz4LKiONWDe0VdtjjzjeTiUkA.jpg"}]',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'section_key' => 'activities',
                'content' => '[{"date":null,"title":"Agricultural Training","description":"Agriculture training within the context of food security mainly on maize and rice in the District of Malaka."},{"date":null,"title":"March 2025","description":"Go to TLE in March 2025 from Atambua for a needs assessment to spread the 15,000 Lt ferro cement water tanks and the GEDSI toilets."},{"date":null,"title":"Teacher Training","description":"Teachers\' training in the Districts of Belu, Malaka and TTU covering the elementary and secondary levels."}]',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'section_key' => 'locations',
                'content' => json_encode([
                    'description' => '<p>The United Timor Development Foundation operates in various locations across Timor Indonesia and Timor Leste, serving communities in both regions with our development initiatives. The total land area of the UNITED TIMOR DEVELOPMENT FOUNDATION amounts to 4,859.7 km2.</p>',
                    'map_image' => null,
                    'timor_indonesia' => [
                        [
                            'title' => 'Belu District',
                            'description' => '<strong>Atambua</strong> of Belu, is about 20 km from the border of <em>Timor L\'Este (TLE)</em>. The influx of TLE refugees started in 1999 which quickly made Atambua a big town, the second largest on West Timor behind Kupang, and the fourth largest in NTT. The District of Belu covers an area of 1,127.3 km².'
                        ],
                        [
                            'title' => 'Malaka District',
                            'description' => '<strong>Betun</strong> of Malaka, borders with Belu District in the northern part, with TTU and TTS on the western part. In the southern part Malaka borders with the Timor Sea and on the eastern part, with TLE and therefore also recipient of TLE refugees. Malaka District covers an area of 1,109.2 km².'
                        ],
                        [
                            'title' => 'North Central Timor',
                            'description' => '<strong>Kefamenanu</strong>, capital of TTU (<em>Timor Tengah Utara</em>), borders with the enclave of TLE in Oekusi/Ambeno. The city hosts less TLE refugees except in the areas closest to the TLE border. Its topography consists of both mountainous and flat areas. TTU covers an area of 623.2 km².'
                        ]
                    ],
                    'timor_leste' => [
                        [
                            'title' => 'Maliana',
                            'description' => '<strong>Maliana</strong> is the capital of Bobonaro District in Timor-Leste (TLE), located near the western border with Indonesia, adjacent to the Belu District. It is one of the key agricultural centers in Timor-Leste, known for its rice production due to the fertile plains and irrigation systems in the area. Maliana town itself covers an area of 239 km².'
                        ],
                        [
                            'title' => 'Oekusi',
                            'description' => '<strong>Oekusi</strong> (also spelled Oecusse), officially known as the Oecusse-Ambeno Special Administrative Region, is an exclave of Timor-Leste (TLE) located within Indonesian territory. The region includes both coastal lowlands and hilly interior terrain. Oekusi covers an area of approximately 814 km².'
                        ],
                        [
                            'title' => 'Dili',
                            'description' => '<strong>Dili</strong> the capital city of Timor-Leste (TLE), is situated on the northern coast of the island along the Ombai Strait. As the largest city and main port of the country, Dili serves as the political, economic, and cultural center of Timor-Leste. Dili covers area of about 368 km².'
                        ]
                    ]
                ]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'section_key' => 'reports',
                'content' => json_encode([
                    [
                        'year' => '2023',
                        'description' => 'UTDF CBR Annual Report 2023',
                        'file' => 'assets/reports/laporan-cbr-2023.docx'
                    ]
                ]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'section_key' => 'support',
                'content' => json_encode([
                    'description' => 'Please join us in our journey to innovate and to respond to the needs of the communities of the UTDF. Your support will be life changing for the people of this part of NTT and Timor Leste. Our financial system is transparent for donors to note of the latest balance, updated monthly. If you wish to donate to the UTDF, please transfer directly to:',
                    'cards' => [
                        [
                            'bank_name' => 'Bank Mandiri',
                            'account_name' => 'Yayasan Colin Barlow Ria',
                            'account_number' => '181-00-0220381-9',
                            'branch_code' => 'KC ATAMBUA 18102',
                            'swift_code' => 'BMRIIDJA'
                        ]
                    ]
                ]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'section_key' => 'contact',
                'content' => json_encode([
                    'description' => 'Get in touch with us for any inquiries about our foundation and community development initiatives.',
                    'contacts' => [
                        [
                            'name' => 'Dr. Ria Gondowarsito',
                            'role' => 'Founder – United Timor Development Foundation',
                            'phone' => '+61 431 371 669',
                            'emails' => 'colinbarlowria@gmail.com, ria081954@gmail.com'
                        ]
                    ]
                ]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
