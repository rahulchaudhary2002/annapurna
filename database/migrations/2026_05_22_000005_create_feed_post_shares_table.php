<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feed_post_shares', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('feed_post_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('platform')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('feed_post_id')->references('id')->on('feed_posts')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feed_post_shares');
    }
};
