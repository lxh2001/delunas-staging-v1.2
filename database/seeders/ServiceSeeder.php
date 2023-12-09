<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'title' => 'Root Canal Therapy',
                'description' => 'Carefully removes the pulp inside the tooth, cleans, disinfects and shapes the root canals, and places a filling to seal the space.',
                'image_path' => 'images/services/root-canal.jpg'
            ],
            [
                'title' => 'Complete Denture',
                'description' => "Takes up the whole mouth rather than just a part of it. It's a removable device that can be used to replace missing teeth and is used by someone who has lost all of their teeth",
                'image_path' => 'images/services/complete denture2.jpg'
            ],
            [
                'title' => 'Removable Partial Denture',
                'description' => "A removable partial denture (RPD) is a dental prosthesis that is used to replace multiple missing teeth.",
                'image_path' => 'images/services/removable-partial-dentures.jpg'
            ],
            [
                'title' => 'Flexible Denture',
                'description' => "Between the acrylic base, metal support structure, and porcelain or resin teeth, a denture is quite rigid, often causing sores and irritation in the mouth.",
                'image_path' => 'images/services/flexible denture.jpg'
            ],
            [
                'title' => 'Dental Braces',
                'description' => "Braces can correct a wide range of dental issues, including crooked, gapped, rotated or crowded teeth.",
                'image_path' => 'images/services/dental braces.png'
            ],
            [
                'title' => 'Tooth Extraction',
                'description' => "A tooth extraction is a dental procedure during which your tooth is completely removed from its socket.",
                'image_path' => 'images/services/Tooth-Extractions.jpg'
            ],
            [
                'title' => 'Oral Prophylaxis',
                'description' => "Oral prophylaxis is a thorough examination of your oral health combined with a scale and clean.",
                'image_path' => 'images/services/oral prophylaxis.jpg'
            ],
            [
                'title' => 'Dental Filling/Pasta',
                'description' => "Tooth Filling or what is commonly known as Dental Pasta is performed to restore proper function and structure.",
                'image_path' => 'images/services/dental filling.jpg'
            ],
            [
                'title' => 'Dental Veneers',
                'description' => "Dental veneers are custom-made shells that fit over the front surfaces of your teeth.",
                'image_path' => 'images/services/dental veneers.jpg'
            ],
            [
                'title' => 'Dental Bridges',
                'description' => "Dental bridges replace missing teeth. They can restore chewing function, enhance your appearance and improve your oral health.",
                'image_path' => 'images/services/dental bridges.jpg'
            ],
        ];

        foreach ($services as $service) {
            // Copy the image to the storage directory
            $imagePath = 'public/' . $service['image_path'];
            Storage::copy($imagePath, 'public/images/uploads/' . basename($service['image_path']));

            // Insert data into the 'services_setting' table
            DB::table('services_settings')->insert([
                'title' => $service['title'],
                'description' => $service['description'],
                'image_url' => 'images/uploads/' . basename($service['image_path']),
            ]);
        }
    }
}
