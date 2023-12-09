<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\PersonalInfoRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Http\Requests\UploadPhotoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return view('portals.patients.my-profile');
    }

    public function uploadPhoto(UploadPhotoRequest $request)
    {
        $validatedRequest = $request->validated();
        try {
            DB::beginTransaction();

            if($request->has('image')) {
                $fileName = time() . '.' . $request->image->extension();
                $filePath = $request->image->move('images/uploads/', $fileName);

                $validatedRequest['image_url'] = $filePath;
            }

            $user = auth()->user();
            $user->image_url = $validatedRequest['image_url'];
            $user->save();

            // Optionally, you can update the authenticated user in the session
            Auth::setUser($user);
            DB::commit();
            return redirect()->route('patient.my-profile')->with('success_message', 'Successfully Updated!');

        }  catch (\Throwable $th) {
            DB::rollBack();
            return $th;
        }
    }

    public function updatePersonalInfo(PersonalInfoRequest $request)
    {
        $validatedRequest = $request->validated();
        try {
            DB::beginTransaction();
            $validatedRequest['middlename'] = $request['middlename'] ?? null;
            $user = auth()->user();
            $user->fill($validatedRequest);
            $user->save();

            Auth::setUser($user);
            DB::commit();
            return redirect()->route('patient.my-profile')->with('success_message', 'Successfully Updated!');

        }  catch (\Throwable $th) {
            DB::rollBack();
            return $th;
        }
    }

    public function updateAccount(UpdateAccountRequest $request)
    {
        $validatedRequest = $request->validated();
        try {
            DB::beginTransaction();
            $user = auth()->user();
            $user->password = Hash::make($validatedRequest['password']);
            $user->save();

            Auth::setUser($user);
            DB::commit();
            return redirect()->route('patient.my-profile')->with('success_message', 'Successfully Updated!');

        }  catch (\Throwable $th) {
            DB::rollBack();
            return $th;
        }
    }
}
