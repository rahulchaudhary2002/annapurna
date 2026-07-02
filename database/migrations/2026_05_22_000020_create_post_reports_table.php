<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('reason');        // spam, inappropriate, misleading, copyright, other
            $table->text('details')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('status')->default('pending'); // pending, reviewed, dismissed
            $table->text('admin_notes')->nullable();
            $table->timestamps();

            $table->index(['post_id', 'status']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_reports');
    }
};
