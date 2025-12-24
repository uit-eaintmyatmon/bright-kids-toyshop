<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('admin.toys.index');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // DEMO: Hardcoded login (remove in production!)
        if ($request->email === 'admin@toyshop.com' && $request->password === 'password') {
            // Create or get admin user
            $admin = \App\Models\User::firstOrCreate(
                ['email' => 'admin@toyshop.com'],
                ['name' => 'Admin', 'password' => bcrypt('password')]
            );
            Auth::login($admin, $request->boolean('remember'));
            $request->session()->regenerate();
            return redirect()->intended(route('admin.toys.index'));
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.toys.index'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
