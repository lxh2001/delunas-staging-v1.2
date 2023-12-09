<?php

namespace Database\Seeders;

use App\Models\MissionVisionSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class MissionVisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $imagePath = 'images/uploads/about-banner1.png';

        MissionVisionSetting::insert([
            'image_url' => $imagePath,
            'vision_header' => 'Vision',
            'vision_description' => 'To create an extraordinary dental practice that is recognized as the best in the community for providing amazing quality and service to both children and adults in a caring family environment.',
            'mission_header' => 'Mission',
            'mission_description' => 'To help every person attain optimum dental health through the best education and state-of-the-art, comfortable dentistry.',
        ]);
    }
}
