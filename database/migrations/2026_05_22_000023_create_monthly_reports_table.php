<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('monthly_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('business_id')->nullable()->constrained()->cascadeOnDelete();
            $table->tinyInteger('period_month');   // 1–12
            $table->smallInteger('period_year');   // e.g. 2026
            $table->json('report_data');           // all stats snapshot
            $table->integer('ranking_position')->nullable();
            $table->integer('ranking_change')->nullable(); // positive = improved, negative = dropped
            $table->string('ranking_tip')->nullable();
            $table->string('status')->default('pending'); // pending, sent, failed
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'period_year', 'period_month']);
            $table->index('status');
            // One report per business per month
            $table->unique(['business_id', 'period_year', 'period_month'], 'monthly_report_biz_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monthly_reports');
    }
};
