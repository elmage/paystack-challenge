<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\FinalizeDisableOtpRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Paystack\PaystackApi;
use App\Transfer\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    protected $paystackApi;

    public function __construct()
    {
        $this->paystackApi = new PaystackApi;
    }

    public function index()
    {
        $otp_status = Cache::rememberForever('otp_status', function () {
            return 1;
        });
        return view('settings.index', ['settings' => 1]);
    }

    public function enableOtp()
    {
        $response = $this->paystackApi->enableOtp();

        Cache::pull('otp_status');
        Cache::rememberForever('otp_status', function () {
            return 1;
        });

        return redirect()->back()->with(['success' => $response['message'], 'preference' => 1]);
    }

    public function disableOtp()
    {
        $response = $this->paystackApi->disableOtp();

        if (strpos($response['message'], 'already disabled') !== false) {
            Cache::pull('otp_status');
            Cache::rememberForever('otp_status', function () {
                return 0;
            });

            return redirect()->back()->with(['success' => $response['message'], 'preference' => 1]);
        } else {
            return redirect()->back()->with(['finalize_otp' => 1, 'preference' => 1]);
        }
    }

    public function finalizeDisableOtp(FinalizeDisableOtpRequest $request)
    {
        $response = $this->paystackApi->finalizeDisableOtp($request->validated());

        if (strpos($response['message'], 'has been disabled') !== false) {
            Cache::pull('otp_status');
            Cache::rememberForever('otp_status', function () {
                return 0;
            });

            return redirect()->back()->with(['success' => $response['message'], 'preference' => 1]);
        }

        return redirect()->back()->with(['error' => $response['message'], 'preference' => 1]);
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $request->user()->update($request->validated());

        return redirect()->back()->with('success', 'Your profile was updated');
    }

    public function updatePassword(ChangePasswordRequest $request)
    {
        $validated = $request->validated();

        if (Hash::check($validated['current_password'], Auth::user()->password)) {
            Auth::user()->update(['password' => bcrypt($validated['password'])]);
            return redirect()->back()->with('success', 'Your password was changed.');
        }

        return redirect()->back()->with('error', 'You entered an incorrect password');
    }

    public function toggleTopup()
    {
        $auto_topup = auto_topup();

        Cache::forget('auto_topup');
        Cache::rememberForever('auto_topup', function () use ($auto_topup) {
            return !$auto_topup;
        });

        return response()->json(['auto_topup' => auto_topup()]);
    }
}