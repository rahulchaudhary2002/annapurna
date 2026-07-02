<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feed_posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('business_id')->nullable();
            $table->enum('type', ['text', 'photo', 'video', 'link', 'announcement', 'offer'])->default('text');
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->json('media')->nullable();
            $table->string('video_url')->nullable();
            $table->string('link_url')->nullable();
            $table->string('link_title')->nullable();
            $table->text('link_description')->nullable();
            $table->string('link_image')->nullable();
            $table->boolean('is_sponsored')->default(false);
            $table->timestamp('sponsored_until')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->unsignedInteger('views_count')->default(0);
            $table->unsignedInteger('likes_count')->default(0);
            $table->unsignedInteger('comments_count')->default(0);
            $table->unsignedInteger('shares_count')->default(0);
            $table->unsignedInteger('saves_count')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('business_id')->references('id')->on('businesses')->nullOnDelete();

            $table->index(['is_published', 'published_at']);
            $table->index(['is_sponsored', 'sponsored_until']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feed_posts');
    }
};
