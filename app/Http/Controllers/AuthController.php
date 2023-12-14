<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Mail\EmailVerification;
use App\Mail\ForgotPasswordEmailNotif;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Str;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Password;
class AuthController extends Controller
{
    public function index(Request $request)
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        //bookNow param
        $bookNow = $request->query('book_now');
        $validatedRequest = $request->validated();

        // Get user by his email
        $user = User::where('email', $validatedRequest['email'])->first();

        //Check if user is exist
        if ($user) {

            //Check if user's email is already verified.
            if($user->verified_otp) {

                //Login the user
                if (!Auth::attempt(['email' => $validatedRequest['email'], 'password' => $validatedRequest['password']])) {
                    return back()->with('error_message', 'Invalid Username and Password');
                }

                if($bookNow && ($user->user_type != 'admin' && $user->user_type != 'doctor')) {
                    return redirect()->route('patient.appointment');
                }

                if($user->user_type == 'admin') {
                    return redirect()->intended(route('admin.dashboard'))->with('status', 'Signed in!');
                }

                if($user->user_type == 'user') {
                    return redirect()->intended(route('patient.dashboard'))->with('status', 'Signed in!');
                }

                if($user->user_type == 'doctor') {
                    return redirect()->intended(route('doctor.dashboard'))->with('status', 'Signed in!');
                }



            } else {
                return redirect()->route('auth.index')->with('error_message', 'You are not verified. Please complete the verification process.');
            }
        } else {
            return redirect()->route('auth.index')->with('error_message', 'Invalid Username and Password');
        }
    }

    public function register(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();
            $bookNow = $request->query('book_now');
            $service = $request->query('service');

            $validatedRequest = $request->validated();

            // Hash the user's password
            $validatedRequest['password'] = Hash::make($validatedRequest['password']);

            // Generate a random token for email verification
            $validatedRequest['remember_token'] = Str::random(40);

            //Add Middlename request
            $validatedRequest['middlename'] = $request['middlename'];

            // Create the user
            $user = User::create($validatedRequest);

            //Add verification query param
            if($bookNow) {
                $user->redirect_route =  route('verify_email', ['verification_code' => $user->remember_token, 'book_now' => true, 'service' => $service]);
            } else {
                $user->redirect_route =  route('verify_email', ['verification_code' => $user->remember_token]);
            }

            // Send an email with the verification link
            // Mail::to($user->email)->send(new EmailVerification($user));
            DB::commit();

            return redirect()->route('auth.index')->with([
                // 'success_message' => 'Your account has been created successfully. Please check your email for a verification link.',
                'success_sms' => 'Your account has been created successfully.',
                'contact_number'  => $user->contact_number,
                'user_id' => $user->id
            ]);

        }  catch (\Throwable $th) {
            DB::rollBack();

            return $th;
        }

    }

    public function verifyEmail($verificationCode, Request $request)
    {
        $bookNow = $request['book_now'];
        $service = $request['service'];
        $user = User::where('remember_token', $verificationCode)->first();

        if(!$user){
            return redirect()->route('auth.index') ;
        }

        if($user->email_verified_at){
            return redirect()->route('auth.index')->with('error_message', 'Email already verified');
        }

        $user->update([
            'email_verified_at' => Carbon::now()
        ]);

         // Log in the user after verification
         Auth::login($user);
         // return auth()->user();
         if($bookNow) {
             return redirect()->route('patient.appointment', ['book_now' => $bookNow, 'service' => $service]);
         }
         return redirect()->route('patient.dashboard');
    }

    public function phoneAuth(Request $request)
    {
        $userId = $request['userId'];
        $user = User::find($userId);

        $user->update([
            'email_verified_at' => Carbon::now(),
            'verified_otp' => true
        ]);

         // Log in the user after verification
         Auth::login($user);
        //  if($bookNow) {
        //      return redirect()->route('patient.appointment', ['book_now' => $bookNow, 'service' => $service]);
        //  }
         return true;
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('auth.index');
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $validatedRequest = $request->validated();

        $user = User::where('email', $validatedRequest['forgot_email'])->first();

        if(!$user) {
            return redirect()->route('auth.login')->with('forgot_email_error', 'Email is not exist');
        }

        // Generate a password reset token and send the reset link notification
        $token = Password::createToken($user);
        $user->token = $token;

        Mail::to($user->email)->send(new ForgotPasswordEmailNotif($user));

        return redirect()->route('auth.login')->with('forgot_email_success', 'Password reset link sent to your email');
    }

    public function resetPasswordPage($token, $email)
    {
        return view('auth.reset-password', compact('token','email'));
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $validatedRequest = $request->validated();

        // Validate the token for a specific user
        $user = Password::getUser(['email' => $validatedRequest['email'], 'token' => $validatedRequest['token']]);

        if (!$user) {
            return redirect()->route('auth.login')->with('token_error', 'Invalid or expired token');
        }

        // Update the user's password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('auth.login')->with('success_message', 'Password successfully reset');
    }
}
