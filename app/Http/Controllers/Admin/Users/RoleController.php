<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));

        $roles = Role::query()
            ->withCount('users')
            ->when($search !== '', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        $permissions = Permission::query()
            ->with(['roles:id,name'])
            ->orderByDesc('created_at')
            ->get(['id', 'name', 'created_at']);

        $roleOptions = Role::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('admin.users.roles', [
            'roles' => $roles,
            'permissions' => $permissions,
            'roleOptions' => $roleOptions,
            'search' => $search,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
        ]);

        Role::create(['name' => $data['name']]);

        return redirect()
            ->route('admin.users.roles')
            ->with('success', 'Role created successfully.');
    }

    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')->ignore($role->id)],
        ]);

        $role->update($data);

        return redirect()
            ->route('admin.users.roles')
            ->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()
            ->route('admin.users.roles')
            ->with('success', 'Role deleted successfully.');
    }
}
