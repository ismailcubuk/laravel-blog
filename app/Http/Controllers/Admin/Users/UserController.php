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
}
