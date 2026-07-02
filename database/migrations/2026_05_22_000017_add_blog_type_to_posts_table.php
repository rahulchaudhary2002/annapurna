<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // official = published by site team, guest = external contributor, business = business owner
            $table->string('blog_type')->default('official')->after('status');
            $table->index('blog_type');
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex(['blog_type']);
            $table->dropColumn('blog_type');
        });
    }
};
