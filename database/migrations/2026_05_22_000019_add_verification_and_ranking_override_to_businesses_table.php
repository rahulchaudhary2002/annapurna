<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->boolean('is_verified')->default(false)->after('is_featured');
            $table->timestamp('verified_at')->nullable()->after('is_verified');
            $table->decimal('ranking_override', 6, 2)->nullable()->after('ranking_score')
                  ->comment('When set, replaces the calculated ranking_score entirely.');
        });
    }

    public function down(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->dropColumn(['is_verified', 'verified_at', 'ranking_override']);
        });
    }
};
