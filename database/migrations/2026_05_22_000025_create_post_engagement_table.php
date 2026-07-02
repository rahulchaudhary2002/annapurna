<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Unified engagement log for business posts AND feed posts.
        // Lets the monthly report aggregate all engagement in one query.
        Schema::create('post_engagement', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            // 'business_post' | 'feed_post'
            $table->string('post_type', 20);
            // 'like' | 'unlike' | 'comment' | 'share' | 'save'
            $table->string('action', 20);
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['post_id', 'post_type', 'action', 'created_at'], 'pe_post_action_idx');
            $table->index(['post_type', 'created_at']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_engagement');
    }
};
