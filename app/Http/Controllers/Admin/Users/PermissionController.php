<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));

        $permissions = Permission::query()
            ->with(['roles:id,name'])
            ->withCount('roles')
            ->when($search !== '', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        $roles = Role::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('admin.users.permissions', [
            'permissions' => $permissions,
            'roles' => $roles,
            'search' => $search,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name'],
        ]);

        Permission::create(['name' => $data['name']]);

        return redirect()
            ->route('admin.users.permissions')
            ->with('success', 'Permission created successfully.');
    }

    public function update(Request $request, Permission $permission)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('permissions', 'name')->ignore($permission->id)],
        ]);

        $permission->update($data);

        return redirect()
            ->route('admin.users.permissions')
            ->with('success', 'Permission updated successfully.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()
            ->route('admin.users.permissions')
            ->with('success', 'Permission deleted successfully.');
    }

    public function syncRoles(Request $request, Permission $permission)
    {
        $data = $request->validate([
            'role_ids' => ['nullable', 'array'],
            'role_ids.*' => ['integer', 'exists:roles,id'],
        ]);

        $permission->roles()->sync($data['role_ids'] ?? []);

        return redirect()
            ->route('admin.users.permissions')
            ->with('success', 'Permission roles updated successfully.');
    }
}
