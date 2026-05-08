<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('comments')) {
            return;
        }

        Schema::table('comments', function (Blueprint $table) {
            if (!Schema::hasColumn('comments', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('post_id')->constrained()->nullOnDelete();
            }

            if (!Schema::hasColumn('comments', 'reply_message')) {
                $table->text('reply_message')->nullable()->after('message');
            }

            if (!Schema::hasColumn('comments', 'replied_by_user_id')) {
                $table->foreignId('replied_by_user_id')->nullable()->after('reply_message')->constrained('users')->nullOnDelete();
            }

            if (!Schema::hasColumn('comments', 'replied_at')) {
                $table->timestamp('replied_at')->nullable()->after('replied_by_user_id');
            }

            if (!Schema::hasColumn('comments', 'status')) {
                $table->string('status')->default('pending')->after('replied_at');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('comments') || !Schema::hasColumn('comments', 'status')) {
            return;
        }

        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
