<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\User;
use App\Services\Mail\MailWorkflowService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function __construct(private MailWorkflowService $mailWorkflow)
    {
    }

    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'remember' => ['nullable', 'boolean'],
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ], $remember)) {
            $request->session()->regenerate();

            $user = $request->user();
            if ($user && $user->role !== 'admin' && empty($user->email_verified_at)) {
                Auth::logout();

                return back()->withErrors([
                    'email' => 'Please verify your email before logging in.',
                ])->onlyInput('email');
            }

            $hasStatusColumn = Schema::hasColumn('users', 'status');
            if ($hasStatusColumn && $user && ($user->status ?? 'active') !== 'active') {
                Auth::logout();

                return back()->withErrors([
                    'email' => 'Your account is currently suspended. Please contact support.',
                ])->onlyInput('email');
            }

            if (Schema::hasColumn('users', 'last_login_at') && $user) {
                $user->forceFill([
                    'last_login_at' => now(),
                ])->save();
            }

            if ($user?->role === 'admin') {
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

    public function showRegister()
    {
        $termsPage = Page::firstOrCreate(
            ['slug' => 'terms-of-use'],
            [
                'title' => 'Terms of Use',
                'description' => '<p>By creating an account or using this website, you agree to these terms.</p>',
            ]
        );

        return view('admin.auth.register', compact('termsPage'));
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
            'email_verified_at' => null,
        ]);

        $token = Str::random(64);
        DB::table('email_verification_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => hash('sha256', $token),
                'created_at' => now(),
            ]
        );

        $verifyUrl = route('admin.email.verify', [
            'token' => $token,
            'email' => $user->email,
        ]);

        $this->mailWorkflow->sendRegistrationVerification($user, $verifyUrl);

        return redirect()->route('admin.login')
            ->with('success', 'Registration successful. Please verify your email from your inbox.');
    }

    public function verifyEmail(Request $request)
    {
        $data = $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $data['email'])->first();
        if (!$user) {
            return redirect()->route('admin.login')->withErrors([
                'email' => 'Verification link is invalid.',
            ]);
        }

        $record = DB::table('email_verification_tokens')
            ->where('email', $data['email'])
            ->first();

        if (!$record || !hash_equals($record->token, hash('sha256', $data['token']))) {
            return redirect()->route('admin.login')->withErrors([
                'email' => 'Verification link is invalid or expired.',
            ]);
        }

        $createdAt = Carbon::parse($record->created_at);
        if ($createdAt->addHours(24)->isPast()) {
            DB::table('email_verification_tokens')->where('email', $data['email'])->delete();

            return redirect()->route('admin.login')->withErrors([
                'email' => 'Verification link expired. Please register again.',
            ]);
        }

        $justVerified = empty($user->email_verified_at);
        $user->forceFill(['email_verified_at' => now()])->save();
        DB::table('email_verification_tokens')->where('email', $data['email'])->delete();

        if ($justVerified) {
            $this->mailWorkflow->sendWelcomeAfterVerification($user);
        }

        return redirect()->route('admin.login')->with('success', 'Email verified successfully. You can now log in.');
    }

    public function showForgotForm()
    {
        return view('admin.auth.forgot-password');
    }

    public function sendPasswordResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $token = Str::random(64);
            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $user->email],
                [
                    'token' => hash('sha256', $token),
                    'created_at' => now(),
                ]
            );

            $resetUrl = route('admin.password.reset', [
                'token' => $token,
                'email' => $user->email,
            ]);

            $this->mailWorkflow->sendPasswordResetRequest($user, $resetUrl);
        }

        return back()->with('success', 'If your email exists in our system, a reset link has been sent.');
    }

    public function showResetForm(string $token, Request $request)
    {
        $email = (string) $request->query('email', '');

        return view('admin.auth.reset-password', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $data = $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $record = DB::table('password_reset_tokens')->where('email', $data['email'])->first();
        if (!$record || !hash_equals($record->token, hash('sha256', $data['token']))) {
            return back()->withErrors(['email' => 'Reset link is invalid.'])->withInput();
        }

        $createdAt = Carbon::parse($record->created_at);
        if ($createdAt->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $data['email'])->delete();

            return back()->withErrors(['email' => 'Reset link expired. Please request a new one.'])->withInput();
        }

        $user = User::where('email', $data['email'])->first();
        if (!$user) {
            return back()->withErrors(['email' => 'User not found.'])->withInput();
        }

        $user->forceFill([
            'password' => Hash::make($data['password']),
        ])->save();

        DB::table('password_reset_tokens')->where('email', $data['email'])->delete();

        return redirect()->route('admin.login')->with('success', 'Password updated successfully. You can log in now.');
    }
}

