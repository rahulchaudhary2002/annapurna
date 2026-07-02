<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_view', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('ip_address', 45)->nullable();
            // Deduplicate: one row per post + ip + date
            $table->date('viewed_on');
            $table->timestamp('created_at')->useCurrent();

            $table->unique(['post_id', 'ip_address', 'viewed_on'], 'blog_view_unique');
            $table->index(['post_id', 'viewed_on']);
            $table->index('viewed_on');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_view');
    }
};
