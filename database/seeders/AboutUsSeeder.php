<?php

namespace Database\Seeders;

use App\Models\AboutUsSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $imagePath = 'images/uploads/about-banner.png';

        AboutUsSetting::insert([
            'image_url' => $imagePath,
            'header' => 'About Us',
            'description' => 'DE LUNAS DENTAL CENTRE is located in 3rd floor Starmall Corner EDSA Shaw Boulevard, Mandaluyong City, and was established by Dr. Zenaida Tutanes DeLunas in 1995 in Kalentong Market, Mandaluyong City. After 7 years, the dental center moved in 2001 to 3rd floor Starmall Corner EDSA Shaw Boulevard, Mandaluyong City, where it is now. The services they offer are root canal therapy, complete dentures, oral prophylaxis, partial denture removal, dental fillings and pastes, flexible dentures, dental veneers, dental bridges, dental braces, and periapical X-rays. It focuses on patients to prevent disease and provide treatment options for the procedures offered.',
        ]);
    }
}
