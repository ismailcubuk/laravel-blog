<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'ui_mode')) {
                $table->string('ui_mode', 20)->nullable()->after('avatar_path');
            }
            if (!Schema::hasColumn('users', 'facebook_url')) {
                $table->string('facebook_url')->nullable()->after('ui_mode');
            }
            if (!Schema::hasColumn('users', 'twitter_url')) {
                $table->string('twitter_url')->nullable()->after('facebook_url');
            }
            if (!Schema::hasColumn('users', 'instagram_url')) {
                $table->string('instagram_url')->nullable()->after('twitter_url');
            }
            if (!Schema::hasColumn('users', 'linkedin_url')) {
                $table->string('linkedin_url')->nullable()->after('instagram_url');
            }
            if (!Schema::hasColumn('users', 'github_url')) {
                $table->string('github_url')->nullable()->after('linkedin_url');
            }
            if (!Schema::hasColumn('users', 'website_url')) {
                $table->string('website_url')->nullable()->after('github_url');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            foreach (['website_url', 'github_url', 'linkedin_url', 'instagram_url', 'twitter_url', 'facebook_url', 'ui_mode'] as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
