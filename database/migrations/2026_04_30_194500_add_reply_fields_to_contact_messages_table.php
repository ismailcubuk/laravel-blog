<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->text('reply_message')->nullable()->after('message');
            $table->foreignId('replied_by_user_id')->nullable()->after('reply_message')->constrained('users')->nullOnDelete();
            $table->timestamp('replied_at')->nullable()->after('replied_by_user_id');

            $table->index('replied_at');
        });
    }

    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropIndex(['replied_at']);
            $table->dropConstrainedForeignId('replied_by_user_id');
            $table->dropColumn(['reply_message', 'replied_at']);
        });
    }
};
