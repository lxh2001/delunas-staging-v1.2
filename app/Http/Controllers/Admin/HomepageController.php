<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HomeBannerRequest;
use App\Http\Requests\MissionRequest;
use App\Http\Requests\ServicesRequest;
use App\Http\Requests\UploadImageMVRequest;
use App\Http\Requests\VisionRequest;
use App\Models\AboutUsSetting;
use App\Models\ContactUs;
use App\Models\HomeSetting;
use App\Models\MissionVisionSetting;
use App\Models\Notification;
use App\Models\ServicesSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Backtrace\File;

class HomepageController extends Controller
{
    public function index()
    {
        $homebanners = HomeSetting::get();
        $services = ServicesSetting::paginate(10);
        $mv = MissionVisionSetting::first();
        $aboutus = AboutUsSetting::first();
        $contactus = ContactUs::orderBy('created_at', 'desc')->paginate(10);

        $countunread = Notification::where('is_read_by_admin', false)->count();
        $notifications = Notification::adminNotifications()->get();

        return view('portals.admins.homepage-settings', compact('homebanners', 'services', 'mv', 'aboutus', 'countunread', 'notifications', 'contactus'));
    }

    public function createAndUpdateHomeBanner(HomeBannerRequest $request)
    {

        $validatedRequest = $request->validated();
        if($request->has('image')) {
            // $fileName = time() . '.' . $request->image->extension();
            // $filePath = $request->image->storeAs('images/uploads', $fileName);

            // $validatedRequest['image_url'] = $filePath;
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->storeAs('public', $imageName);
            $data['image_url'] = $imageName;
        }

        HomeSetting::updateOrCreate(
            [
                'id' => $request['id']
            ],
            $validatedRequest,
        );

        return redirect()->route('admin.homepage')->with('success_msg', 'Successfully Updated!');
    }

    public function createAndUpdateAboutUs(HomeBannerRequest $request)
    {

        $validatedRequest = $request->validated();
        if($request->has('image')) {
            // $fileName = time() . '.' . $request->image->extension();
            // $filePath = $request->image->move('images/uploads/', $fileName);

            // $validatedRequest['image_url'] = $filePath;
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->storeAs('public', $imageName);
            $data['image_url'] = $imageName;
        }

        AboutUsSetting::updateOrCreate(
            [
                'id' => $request['id']
            ],
            $validatedRequest,
        );

        return redirect()->route('admin.homepage')->with('success_msg', 'Successfully Updated!');
    }

    public function createAndUpdateUploadImageMissionVision(UploadImageMVRequest $request)
    {

        $validatedRequest = $request->validated();
        if($request->has('image')) {
            // $fileName = time() . '.' . $request->image->extension();
            // $filePath = $request->image->move('images/uploads/', $fileName);

            // $validatedRequest['image_url'] = $filePath;
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->storeAs('public', $imageName);
            $data['image_url'] = $imageName;
        }

        MissionVisionSetting::updateOrCreate(
            [
                'id' => $request['id']
            ],
            $validatedRequest,
        );

        return redirect()->route('admin.homepage')->with('success_msg', 'Successfully Updated!');
    }

    public function createAndUpdateMission(MissionRequest $request)
    {

        $validatedRequest = $request->validated();

        MissionVisionSetting::updateOrCreate(
            [
                'id' => $request['id']
            ],
            $validatedRequest,
        );

        return redirect()->route('admin.homepage')->with('success_msg', 'Successfully Updated!');
    }

    public function createAndUpdateVision(VisionRequest $request)
    {

        $validatedRequest = $request->validated();

        MissionVisionSetting::updateOrCreate(
            [
                'id' => $request['id']
            ],
            $validatedRequest,
        );

        return redirect()->route('admin.homepage')->with('success_msg', 'Successfully Updated!');
    }

    public function createService(ServicesRequest $request)
    {
        $validatedRequest = $request->validated();

        if($request->has('image')) {
            // $fileName = time() . '.' . $request->image->extension();
            // // $request->image->storeAs('public/img/uploads', $fileName);
            // $filePath = $request->image->move('img/uploads/', $fileName);

            // $validatedRequest['image_url'] = $filePath;
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->storeAs('public', $imageName);
            $data['image_url'] = $imageName;
        }

        ServicesSetting::create($validatedRequest);

        return response()->json(['status' => true, 'message' => 'Service Created Successfully']);
    }

    public function updateService(ServicesRequest $request, ServicesSetting $service)
    {
        $validatedRequest = $request->validated();

        if($request->has('image')) {
            // $fileName = time() . '.' . $request->image->extension();
            // // $request->image->storeAs('public/img/uploads', $fileName);
            // $filePath = $request->image->move('img/uploads/', $fileName);
            // $service->image_url = $filePath;
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->storeAs('public', $imageName);
            $data['image_url'] = $imageName;
        }

        $service->title = $validatedRequest['title'];
        $service->description = $validatedRequest['description'];
        $service->update();

        return response()->json([ 'status' => true,'message' => 'Service Updated Successfully' ]);
    }
}
