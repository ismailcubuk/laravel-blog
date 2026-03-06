<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->primary(['role_id', 'user_id']);
        });

        $now = now();
        DB::table('roles')->insert([
            ['name' => 'Admin', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'User', 'created_at' => $now, 'updated_at' => $now],
        ]);

        if (Schema::hasColumn('users', 'role')) {
            $roleIds = DB::table('roles')->pluck('id', 'name');

            DB::table('users')
                ->select(['id', 'role'])
                ->orderBy('id')
                ->chunk(500, function ($users) use ($roleIds, $now) {
                    $rows = [];

                    foreach ($users as $user) {
                        $roleName = $user->role === 'admin' ? 'Admin' : 'User';
                        $rows[] = [
                            'role_id' => $roleIds[$roleName],
                            'user_id' => $user->id,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ];
                    }

                    if (!empty($rows)) {
                        DB::table('role_user')->insertOrIgnore($rows);
                    }
                });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('roles');
    }
};
