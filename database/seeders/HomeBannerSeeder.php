<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HomeBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $homebanners = [
            [
                'header' => 'Dental Clinic That You Can Trust',
                'description' => "<p>Looking for a trusted dentist? You've made a right place to book an appointment.&nbsp;</p>
                <p>Delunas Dental Centre is here to make your smile better and make sure that the services we provide to you is good. We have many different services that can be seen below. 2</p>",
                'image_path' => 'images/hero-section/slider0.jpg'
            ],
            [
                'header' => 'Discover Our Comprehensive Dental Services',
                'description' => "<p class='MsoNormal'>Transforming Smiles with Expert Care and Cutting-Edge Dentistry, Where Your Comfort is Our Priority. We're here to make every visit a pleasant experience, so you can achieve the smile of your dreams with confidence.</p>".
                "<p class='MsoNormal'>&nbsp;</p>",
                'image_path' => 'images/hero-section/slider1.jpg'
            ],
            [
                'header' => 'Advanced Dental Equipment',
                'description' => "<p class='MsoNormal'>Enhancing Your Dental Care with Advanced Technology. Our practice is equipped with the latest advancements in dental equipment, ensuring precision, comfort, and efficiency in every&nbsp; procedure. Discover how our equipment enhances your oral health&nbsp; journey.</p>".
                "<p class='MsoNormal'>&nbsp;</p>",
                'image_path' => 'images/hero-section/slider2.jpg'
            ],
        ];

        foreach ($homebanners as $home) {
            // Copy the image to the storage directory
            $imagePath = 'public/' . $home['image_path'];
            Storage::copy($imagePath, 'public/images/uploads/' . basename($home['image_path']));

            // Insert data into the 'services_setting' table
            DB::table('home_settings')->insert([
                'header' => $home['header'],
                'description' => $home['description'],
                'image_url' => 'images/uploads/' . basename($home['image_path']),
            ]);
        }
    }
}
