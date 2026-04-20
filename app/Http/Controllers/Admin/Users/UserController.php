<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));
        $roleFilter = trim((string) $request->query('role', ''));
        $sort = (string) $request->query('sort', 'created_at');
        $direction = strtolower((string) $request->query('direction', 'desc'));

        $allowedSorts = ['name', 'email', 'role', 'created_at'];
        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'created_at';
        }

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'desc';
        }

        $usersQuery = User::query()
            ->with(['roles:id,name'])
            ->select(['id', 'name', 'email', 'role', 'created_at'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('role', 'like', '%' . $search . '%')
                        ->orWhereHas('roles', function ($roleQuery) use ($search) {
                            $roleQuery->where('name', 'like', '%' . $search . '%');
                        });
                });
            })
            ->when($roleFilter !== '', function ($query) use ($roleFilter) {
                $query->where(function ($inner) use ($roleFilter) {
                    $inner->whereRaw('LOWER(COALESCE(NULLIF(role, ""), "user")) = ?', [strtolower($roleFilter)])
                        ->orWhereHas('roles', function ($roleQuery) use ($roleFilter) {
                            $roleQuery->whereRaw('LOWER(name) = ?', [strtolower($roleFilter)]);
                        });
                });
            })
            ->orderBy($sort, $direction)
            ->orderBy('id', 'desc');

        $users = $usersQuery->paginate(12)->withQueryString();

        $roleCounts = User::query()
            ->selectRaw('COALESCE(NULLIF(role, ""), "user") as role_name, COUNT(*) as total')
            ->groupBy('role_name')
            ->pluck('total', 'role_name');

        $roles = Role::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('admin.users.list', [
            'users' => $users,
            'roleCounts' => $roleCounts,
            'roles' => $roles,
            'search' => $search,
            'roleFilter' => $roleFilter,
            'sort' => $sort,
            'direction' => $direction,
        ]);
    }

    public function updateRole(Request $request, User $user)
    {
        $data = $request->validate([
            'role_id' => ['required', 'integer', 'exists:roles,id'],
        ]);

        $role = Role::query()->findOrFail($data['role_id']);

        $user->roles()->sync([$role->id]);
        $user->update([
            'role' => Str::lower(trim($role->name)),
        ]);

        return back()->with('success', 'User role updated successfully.');
    }

    public function edit(User $user)
    {
        $roles = Role::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        $currentRoleId = optional($user->roles->first())->id;
        if (!$currentRoleId && filled($user->role)) {
            $normalizedUserRole = strtolower(trim((string) $user->role));
            $fallbackRole = $roles->first(function ($item) use ($normalizedUserRole) {
                return strtolower((string) $item->name) === $normalizedUserRole;
            });
            $currentRoleId = optional($fallbackRole)->id;
        }

        return view('admin.users.edit', [
            'user' => $user->loadMissing('roles:id,name'),
            'roles' => $roles,
            'currentRoleId' => $currentRoleId,
            'statuses' => ['active', 'suspended'],
            'hasStatusColumn' => Schema::hasColumn('users', 'status'),
            'hasLastLoginColumn' => Schema::hasColumn('users', 'last_login_at'),
        ]);
    }

    public function update(Request $request, User $user)
    {
        $hasStatusColumn = Schema::hasColumn('users', 'status');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role_id' => ['required', 'integer', 'exists:roles,id'],
            'status' => [$hasStatusColumn ? 'required' : 'nullable', 'in:active,suspended'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        $role = Role::query()->findOrFail($validated['role_id']);

        $payload = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => Str::lower(trim($role->name)),
        ];

        if ($hasStatusColumn && array_key_exists('status', $validated) && filled($validated['status'])) {
            $payload['status'] = $validated['status'];
        }

        if (filled($validated['password'] ?? null)) {
            $payload['password'] = Hash::make($validated['password']);
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
            $payload['avatar_path'] = '/uploads/profiles/' . $filename;
        }

        $user->update($payload);
        $user->roles()->sync([$role->id]);

        return redirect()
            ->route('admin.users.edit', $user)
            ->with('success', 'User updated successfully.');
    }

    private function resolveAvatarDestination(): string
    {
        return base_path('../uploads/profiles');
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
