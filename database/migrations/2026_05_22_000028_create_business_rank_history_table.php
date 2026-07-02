<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('business_rank_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained()->cascadeOnDelete();
            $table->decimal('ranking_score', 8, 4)->default(0);
            $table->decimal('ranking_override', 6, 2)->nullable();
            // Effective score used = COALESCE(ranking_override, ranking_score)
            $table->decimal('effective_score', 8, 4)->default(0);
            // Position among all active businesses at snapshot time
            $table->unsignedInteger('position');
            $table->unsignedInteger('total_businesses');
            $table->tinyInteger('recorded_month');  // 1–12
            $table->smallInteger('recorded_year');
            $table->timestamp('created_at')->useCurrent();

            $table->unique(['business_id', 'recorded_year', 'recorded_month'], 'rank_history_unique');
            $table->index(['business_id', 'recorded_year', 'recorded_month'], 'rank_history_biz_year_month_idx');
            $table->index(['recorded_year', 'recorded_month']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('business_rank_history');
    }
};
