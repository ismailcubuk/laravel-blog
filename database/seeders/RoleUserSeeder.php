<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoleUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::query()->where('name', 'Admin')->first();
        $userRole = Role::query()->where('name', 'User')->first();

        if (!$adminRole || !$userRole) {
            return;
        }

        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => 'password',
                'role' => 'admin',
                'avatar_path' => 'assets/images/avatars/admin-profile.png',
            ]
        );

        $user = User::query()->updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'User',
                'password' => 'password',
                'role' => 'user',
                'avatar_path' => 'assets/images/avatars/reader-one.png',
            ]
        );

        $admin->roles()->syncWithoutDetaching([$adminRole->id]);
        $user->roles()->syncWithoutDetaching([$userRole->id]);

        $permanentAdminEmail = 'iismailcubuk@gmail.com';

        // Keep email unique by moving conflicting rows to a fallback email.
        User::query()
            ->where('email', $permanentAdminEmail)
            ->where('id', '!=', 1)
            ->get()
            ->each(function (User $conflictUser) {
                $conflictUser->update([
                    'email' => 'migrated+' . $conflictUser->id . '+' . Str::random(6) . '@example.com',
                ]);
            });

        $permanentAdmin = User::query()->updateOrCreate(
            ['id' => 1],
            [
                'name' => 'ismail cubuk',
                'email' => $permanentAdminEmail,
                'password' => 'asdasd',
                'role' => 'admin',
                'avatar_path' => 'assets/images/avatars/admin-profile.png',
            ]
        );

        // Force role relation to admin for the permanent account.
        $permanentAdmin->roles()->sync([$adminRole->id]);

        $avatars = [
            'assets/images/avatars/admin-profile.png',
            'assets/images/avatars/emma-carter.png',
            'assets/images/avatars/noah-bennett.png',
            'assets/images/avatars/mia-brooks.png',
            'assets/images/avatars/reader-one.png',
            'assets/images/avatars/reader-two.png',
        ];

        User::query()
            ->whereNull('avatar_path')
            ->orWhere('avatar_path', '')
            ->orderBy('id')
            ->get()
            ->each(function (User $seedUser, int $index) use ($avatars) {
                $seedUser->update([
                    'avatar_path' => $avatars[$index % count($avatars)],
                ]);
            });
    }
}
