<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactUsRequest;
use App\Models\AboutUsSetting;
use App\Models\ContactUs;
use App\Models\HomeSetting;
use App\Models\MissionVisionSetting;
use App\Models\Rating;
use App\Models\ServicesSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index() {

        $services = ServicesSetting::get();
        $banners = HomeSetting::get();
        $mv = MissionVisionSetting::first();
        $aboutus = AboutUsSetting::first();
        $feedbacks = Rating::get();
        return view("index.index", compact('services', 'banners', 'mv', 'aboutus', 'feedbacks'));
    }

    public function contactUs(ContactUsRequest $request)
    {
        try {
            DB::beginTransaction();

            $validatedRequest = $request->validated();

            // Create the user
            ContactUs::create($validatedRequest);

            DB::commit();
            return redirect()->route('index')->with([
                'fragment' => 'contact',
                'success_contact' => "Your message has been received. We'll get back to you as soon as possible. Thank you!",
            ]);
        }  catch (\Throwable $th) {
            DB::rollBack();

            return $th;
        }
    }
}
