<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\AboutUsSetting;
use App\Models\HomeSetting;
use App\Models\MissionVisionSetting;
use App\Models\ServicesSetting;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if(User::count() === 0) {
            $this->call(UserSeeder::class);
        }

        if(HomeSetting::count() === 0) {
            $this->call(HomeBannerSeeder::class);
        }

        if(ServicesSetting::count() === 0) {
            $this->call(ServiceSeeder::class);
        }

        if(MissionVisionSetting::count() === 0) {
            $this->call(MissionVisionSeeder::class);
        }

        if(AboutUsSetting::count() === 0) {
            $this->call(AboutUsSeeder::class);
        }

    }
}
