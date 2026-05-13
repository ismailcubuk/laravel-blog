<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            if (!Schema::hasColumn('posts', 'meta_title')) {
                $table->string('meta_title')->nullable()->after('content');
            }

            if (!Schema::hasColumn('posts', 'meta_description')) {
                $table->string('meta_description', 320)->nullable()->after('meta_title');
            }

            if (!Schema::hasColumn('posts', 'canonical_url')) {
                $table->string('canonical_url')->nullable()->after('meta_description');
            }

            if (!Schema::hasColumn('posts', 'og_image')) {
                $table->string('og_image')->nullable()->after('canonical_url');
            }

            if (!Schema::hasColumn('posts', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('status');
            }

            if (!Schema::hasColumn('posts', 'featured_at')) {
                $table->timestamp('featured_at')->nullable()->after('is_featured');
            }
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            foreach (['featured_at', 'is_featured', 'og_image', 'canonical_url', 'meta_description', 'meta_title'] as $column) {
                if (Schema::hasColumn('posts', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
