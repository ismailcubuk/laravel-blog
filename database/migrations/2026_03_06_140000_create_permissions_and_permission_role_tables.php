<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('permission_role', function (Blueprint $table) {
            $table->foreignId('permission_id')->constrained('permissions')->cascadeOnDelete();
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();
            $table->timestamps();

            $table->primary(['permission_id', 'role_id']);
        });

        $now = now();
        DB::table('permissions')->insert([
            ['name' => 'View Dashboard', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Manage Users', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Manage Roles', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Create Posts', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Edit Posts', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('permissions');
    }
};
