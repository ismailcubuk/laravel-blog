<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // LOGIN PAGE
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    // LOGIN 
    public function login()
    {
        // basit session oluştur
        session(['admin_logged_in' => true]);

        return redirect()->route('admin.dashboard');
    }

    // REGISTER PAGE
    public function showRegister()
    {
        return view('admin.auth.register');
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

    // LOGOUT
    public function logout()
    {
        session()->forget('admin_logged_in');

        return redirect()->route('admin.login');
    }
}
