<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));

        $usersQuery = User::query()
            ->select(['id', 'name', 'email', 'role', 'created_at'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('role', 'like', '%' . $search . '%');
                });
            })
            ->orderByDesc('created_at');

        $users = $usersQuery->paginate(12)->withQueryString();

        $roleCounts = User::query()
            ->selectRaw('COALESCE(NULLIF(role, ""), "user") as role_name, COUNT(*) as total')
            ->groupBy('role_name')
            ->pluck('total', 'role_name');

        return view('admin.users.roles', [
            'users' => $users,
            'roleCounts' => $roleCounts,
            'search' => $search,
        ]);
    }
}
