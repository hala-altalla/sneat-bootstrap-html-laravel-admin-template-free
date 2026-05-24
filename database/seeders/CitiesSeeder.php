<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $cities = [
        ['en' => 'Damascus',     'ar' => 'دمشق'],
        ['en' => 'Aleppo',       'ar' => 'حلب'],
        ['en' => 'Homs',         'ar' => 'حمص'],
        ['en' => 'Hama',         'ar' => 'حماة'],
        ['en' => 'Latakia',      'ar' => 'اللاذقية'],
        ['en' => 'Tartus',       'ar' => 'طرطوس'],
        ['en' => 'Raqqa',        'ar' => 'الرقة'],
        ['en' => 'Deir ez-Zor',  'ar' => 'دير الزور'],
        ['en' => 'Idlib',        'ar' => 'إدلب'],
        ['en' => 'Daraa',        'ar' => 'درعا'],
        ['en' => 'Al-Qamishli',  'ar' => 'القامشلي'],
        ['en' => 'Al-Hasakah',   'ar' => 'الحسكة'],
        ['en' => 'Suwayda',      'ar' => 'السويداء'],
    ];

    foreach ($cities as $city) {
        City::create([
            'name' => $city,
        ]);
    }
}
}