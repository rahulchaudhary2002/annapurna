<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feed_post_likes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('feed_post_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('feed_post_id')->references('id')->on('feed_posts')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();

            $table->unique(['feed_post_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feed_post_likes');
    }
};
