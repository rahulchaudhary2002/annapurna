<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feed_post_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('feed_post_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->text('content');
            $table->boolean('is_published')->default(true);
            $table->timestamps();

            $table->foreign('feed_post_id')->references('id')->on('feed_posts')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('parent_id')->references('id')->on('feed_post_comments')->nullOnDelete();

            $table->index(['feed_post_id', 'is_published']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feed_post_comments');
    }
};
