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

        $admin = User::query()->firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => 'password',
                'role' => 'admin',
            ]
        );

        $user = User::query()->firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'User',
                'password' => 'password',
                'role' => 'user',
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
            ]
        );

        // Force role relation to admin for the permanent account.
        $permanentAdmin->roles()->sync([$adminRole->id]);
    }
}
