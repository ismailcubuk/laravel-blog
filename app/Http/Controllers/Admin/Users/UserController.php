<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));

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
            ->orderByDesc('created_at');

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
}
