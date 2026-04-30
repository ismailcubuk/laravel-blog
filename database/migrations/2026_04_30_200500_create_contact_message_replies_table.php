<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('contact_message_replies')) {
            Schema::create('contact_message_replies', function (Blueprint $table) {
                $table->id();
                $table->foreignId('contact_message_id')->constrained()->cascadeOnDelete();
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
                $table->text('message');
                $table->timestamps();

                $table->index(['contact_message_id', 'created_at']);
            });
        }

        if (Schema::hasColumn('contact_messages', 'reply_message')) {
            DB::table('contact_messages')
                ->whereNotNull('reply_message')
                ->orderBy('id')
                ->get(['id', 'reply_message', 'replied_by_user_id', 'replied_at', 'updated_at'])
                ->each(function ($message) {
                    $alreadyMigrated = DB::table('contact_message_replies')
                        ->where('contact_message_id', $message->id)
                        ->where('message', $message->reply_message)
                        ->exists();

                    if ($alreadyMigrated) {
                        return;
                    }

                    DB::table('contact_message_replies')->insert([
                        'contact_message_id' => $message->id,
                        'user_id' => $message->replied_by_user_id,
                        'message' => $message->reply_message,
                        'created_at' => $message->replied_at ?: $message->updated_at ?: now(),
                        'updated_at' => $message->replied_at ?: $message->updated_at ?: now(),
                    ]);
                });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_message_replies');
    }
};
