<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->decimal('ranking_score', 6, 2)->default(0)->after('order');
            $table->tinyInteger('profile_completeness_score')->default(0)->after('ranking_score');
            $table->index('ranking_score');
        });
    }

    public function down(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->dropIndex(['ranking_score']);
            $table->dropColumn(['ranking_score', 'profile_completeness_score']);
        });
    }
};
