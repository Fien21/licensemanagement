<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminAuthController extends Controller
{
    /**
     * Show the create-password page.
     * Only shown if admin password is not yet set.
     */
    public function showCreatePassword()
    {
        $admin = User::where('email', 'admin@example.com')->firstOrFail();

        // Redirect to login if password already exists
        if ($admin->password) {
            return redirect()->route('admin.login');
        }

        return view('welcome.create-password');
    }

    /**
     * Handle storing the admin password.
     */
    public function storePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);

        $admin = User::where('email', 'admin@example.com')->firstOrFail();

        if ($admin->password) {
            return redirect()->route('admin.login');
        }

        $admin->password = Hash::make($request->password);
        $admin->save();

        return redirect()->route('admin.login')->with('success', 'Password created successfully! You can now login.');
    }

    /**
     * Show login page.
     */
    public function showLogin()
    {
        return view('welcome.login');
    }

    /**
     * Handle login submission.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/'); // Dashboard
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
