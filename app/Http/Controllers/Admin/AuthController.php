<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('admin.pages.auth.login');
    }

    public function forgetPage()
    {
        return view('admin.pages.auth.forget-password');
    }

    public function loginStore(LoginRequest $request)
    {
//        dd($request->all());
        $user = User::where('email', $request->email)->first();

        // Email exists?
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => __('Invalid email or password.'),
            ]);
        }

        // Verify Security Code
        if (! Hash::check($request->security_code, $user->security_code_hash)) {
            throw ValidationException::withMessages([
                'security_code' => __('Invalid security code.'),
            ]);
        }

        // Check Security Code Expiry (optional)
        if (
            $user->security_code_expires_at &&
            now()->greaterThan($user->security_code_expires_at)
        ) {
            throw ValidationException::withMessages([
                'security_code' => __('Security code has expired.'),
            ]);
        }

        /**
         * One Device Binding
         */

        if (blank($user->device_id)) {

            // First login → Bind device
            $user->update([
                'device_id' => $request->device_id,
                'device_name' => $request->device_name,
                'device_bound_at' => now(),
                'last_device_activity_at' => now(),
            ]);

        } elseif ($user->device_id !== $request->device_id) {

            throw ValidationException::withMessages([
                'email' => __('This account is already linked to another device.'),
            ]);

        } else {

            $user->update([
                'last_device_activity_at' => now(),
                'device_name' => $request->device_name,
            ]);
        }

        Auth::login($user, true);

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'))
            ->with('success', 'Login successful.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
