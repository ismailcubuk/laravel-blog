<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('comments')) {
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

            return;
        }

        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('email');
            $table->text('message');
            $table->text('reply_message')->nullable();
            $table->foreignId('replied_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('replied_at')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();

            $table->index(['post_id', 'status']);
            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
