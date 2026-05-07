<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            if (!Schema::hasColumn('posts', 'status')) {
                $table->string('status', 20)->default('published')->after('user_id');
                $table->index(['status', 'created_at']);
                $table->index(['user_id', 'status']);
            }
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            if (Schema::hasColumn('posts', 'status')) {
                $table->dropIndex(['status', 'created_at']);
                $table->dropIndex(['user_id', 'status']);
                $table->dropColumn('status');
            }
        });
    }
};
