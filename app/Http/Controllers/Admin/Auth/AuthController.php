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
    //  Validation
    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    //  Attempt login
    if (Auth::attempt([
        'email' => $request->email,
        'password' => $request->password,
        'role' => 'admin'
    ], $request->boolean('remember'))) {

        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    // Cant login
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
        // 1. Validation
$request->validate([
    'name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'email:rfc,dns', 'unique:users,email'],
    'password' => ['required', 'string', 'min:6', 'confirmed'],
    'terms' => ['accepted'],
]);

        // 2. New user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin'
        ]);

        // 3. Login 
        Auth::login($user);

        // 4. Dashboard
        return redirect()->route('admin.login');
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

