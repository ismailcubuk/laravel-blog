<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Mail\MailWorkflowService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function __construct(private MailWorkflowService $mailWorkflow)
    {
    }

    public function edit(Request $request)
    {
        $user = $request->user();

        return view('admin.users.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $currentEmail = (string) $user->email;

        $rawPhone = (string) $request->input('phone', '');
        $phoneDigits = preg_replace('/\D+/', '', $rawPhone);
        $normalizedPhone = null;

        if ($phoneDigits !== '') {
            if (str_starts_with($phoneDigits, '90') && strlen($phoneDigits) === 12) {
                $phoneDigits = substr($phoneDigits, 2);
            } elseif (str_starts_with($phoneDigits, '0') && strlen($phoneDigits) === 11) {
                $phoneDigits = substr($phoneDigits, 1);
            }

            if (strlen($phoneDigits) === 10 && str_starts_with($phoneDigits, '5')) {
                $normalizedPhone = sprintf(
                    '+90 %s %s %s %s',
                    substr($phoneDigits, 0, 3),
                    substr($phoneDigits, 3, 3),
                    substr($phoneDigits, 6, 2),
                    substr($phoneDigits, 8, 2),
                );
            }
        }

        $request->merge(['phone' => $normalizedPhone]);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'regex:/^\+90 5\d{2} \d{3} \d{2} \d{2}$/'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'facebook_url' => ['nullable', 'string', 'max:255'],
            'twitter_url' => ['nullable', 'string', 'max:255'],
            'instagram_url' => ['nullable', 'string', 'max:255'],
            'linkedin_url' => ['nullable', 'string', 'max:255'],
            'github_url' => ['nullable', 'string', 'max:255'],
            'website_url' => ['nullable', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        foreach (['facebook_url', 'twitter_url', 'instagram_url', 'linkedin_url', 'github_url', 'website_url'] as $field) {
            $data[$field] = $this->normalizeSocialUrl((string) ($data[$field] ?? ''), $field);
        }

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $destination = $this->resolveAvatarDestination();

            if (!is_dir($destination)) {
                mkdir($destination, 0755, true);
            }

            $this->deleteOldAvatar((string) $user->avatar_path);
            $file->move($destination, $filename);
            $data['avatar_path'] = '/uploads/profiles/' . $filename;
        }

        $newEmail = strtolower(trim((string) $data['email']));
        $emailChanged = strcasecmp($newEmail, $currentEmail) !== 0;

        if ($emailChanged) {
            $pendingUsedByAnotherUser = DB::table('email_change_requests')
                ->where('new_email', $newEmail)
                ->where('user_id', '!=', $user->id)
                ->exists();

            if ($pendingUsedByAnotherUser) {
                return back()->withErrors([
                    'email' => 'This email is waiting for verification in another account. Please try another email.',
                ])->withInput();
            }
        }

        unset($data['email']);
        unset($data['avatar']);

        $user->update($data);

        if ($emailChanged) {
            $token = Str::random(64);

            DB::table('email_change_requests')->updateOrInsert(
                ['user_id' => $user->id],
                [
                    'new_email' => $newEmail,
                    'token' => hash('sha256', $token),
                    'created_at' => now(),
                ]
            );

            $requestRecordId = DB::table('email_change_requests')
                ->where('user_id', $user->id)
                ->value('id');

            $verifyUrl = route('admin.users.profile.email.verify', [
                'requestId' => $requestRecordId,
                'token' => $token,
            ]);

            $this->mailWorkflow->sendEmailChangeVerification($user->name, $newEmail, $verifyUrl);

            return back()->with(
                'success',
                'Profile updated. We sent a verification email to your new address. Confirm it to complete the email change.'
            );
        }

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if (!Hash::check($data['current_password'], $user->password)) {
            return back()->withErrors([
                'current_password' => 'Current password is incorrect.',
            ])->withInput();
        }

        $user->update([
            'password' => Hash::make($data['new_password']),
        ]);

        return back()->with('password_success', 'Password updated successfully.');
    }

    public function verifyEmailChange(Request $request, int $requestId)
    {
        $data = $request->validate([
            'token' => ['required', 'string'],
        ]);

        $record = DB::table('email_change_requests')->where('id', $requestId)->first();
        if (!$record || !hash_equals((string) $record->token, hash('sha256', $data['token']))) {
            return redirect()->route('login')->withErrors([
                'email' => 'Email change link is invalid or expired.',
            ]);
        }

        $createdAt = Carbon::parse($record->created_at);
        if ($createdAt->addHours(24)->isPast()) {
            DB::table('email_change_requests')->where('id', $requestId)->delete();

            return redirect()->route('login')->withErrors([
                'email' => 'Email change link expired. Please request a new one from profile settings.',
            ]);
        }

        $user = User::find($record->user_id);
        if (!$user) {
            DB::table('email_change_requests')->where('id', $requestId)->delete();

            return redirect()->route('login')->withErrors([
                'email' => 'Email change request is no longer valid.',
            ]);
        }

        $targetEmail = strtolower(trim((string) $record->new_email));
        $alreadyTaken = User::query()
            ->where('email', $targetEmail)
            ->where('id', '!=', $user->id)
            ->exists();

        if ($alreadyTaken) {
            DB::table('email_change_requests')->where('id', $requestId)->delete();

            if (auth()->check() && (int) auth()->id() === (int) $user->id) {
                return redirect()->route('admin.users.profile')->withErrors([
                    'email' => 'This email address is already in use. Please try another email.',
                ]);
            }

            return redirect()->route('login')->withErrors([
                'email' => 'This email address is already in use. Please try another email.',
            ]);
        }

        $user->forceFill([
            'email' => $targetEmail,
            'email_verified_at' => now(),
        ])->save();

        DB::table('email_change_requests')->where('id', $requestId)->delete();

        if (auth()->check() && (int) auth()->id() === (int) $user->id) {
            return redirect()->route('admin.users.profile')->with('success', 'Email address updated successfully.');
        }

        return redirect()->route('login')->with('success', 'Email address updated successfully. You can continue with your new email.');
    }

    private function resolveAvatarDestination(): string
    {
        return base_path('../uploads/profiles');
    }

    private function normalizeSocialUrl(string $rawValue, string $field): ?string
    {
        $value = trim($rawValue);
        if ($value === '') {
            return null;
        }

        if (preg_match('/^https?:\/\//i', $value)) {
            return filter_var($value, FILTER_VALIDATE_URL) ? $value : null;
        }

        $handle = trim(ltrim($value, '@/ '));
        $handle = preg_replace('/\s+/', '', $handle);
        if ($handle === '') {
            return null;
        }

        return match ($field) {
            'facebook_url' => 'https://facebook.com/' . $handle,
            'twitter_url' => 'https://x.com/' . $handle,
            'instagram_url' => 'https://instagram.com/' . $handle,
            'linkedin_url' => 'https://linkedin.com/in/' . $handle,
            'github_url' => 'https://github.com/' . $handle,
            'website_url' => 'https://' . preg_replace('/^\/+/', '', $handle),
            default => null,
        };
    }

    private function deleteOldAvatar(string $avatarPath): void
    {
        if ($avatarPath === '' || !str_starts_with($avatarPath, '/uploads/profiles/')) {
            return;
        }

        $relative = ltrim($avatarPath, '/');
        $candidates = [
            base_path('../' . $relative),
            public_path($relative),
        ];

        foreach ($candidates as $candidate) {
            if (is_file($candidate)) {
                @unlink($candidate);
            }
        }
    }
}


