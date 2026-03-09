<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // LOGIN PAGE
    public function showLogin()
    {
        return view('admin.auth.login');
    }

// LOGIN
public function login(Request $request)
{
    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt([
        'email' => $request->email,
        'password' => $request->password,
    ], $request->boolean('remember'))) {

        $request->session()->regenerate();

        if ($request->user()?->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('home');
    }

    return back()->withErrors([
    'email' => 'Invalid email or password.',
    ])->onlyInput('email');
}


public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('home');
}

    // REGISTER PAGE
    public function showRegister()
    {
        return view('admin.auth.register');
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'terms' => ['accepted'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('home');
    }

    // FORGOT PASSWORD PAGE
    public function showForgotForm()
    {
        return view('admin.auth.forgot-password');
    }

    // RESET PAGE
    public function showResetForm()
    {
        return view('admin.auth.reset-password');
    }
}

