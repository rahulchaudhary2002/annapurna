<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('package_view', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained()->cascadeOnDelete();
            // Denormalised for fast grouping by business
            $table->foreignId('business_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('ip_address', 45)->nullable();
            // where the visitor came from: listing, business_profile, home, search, direct
            $table->string('source', 30)->nullable();
            $table->date('viewed_on');
            $table->timestamp('created_at')->useCurrent();

            $table->unique(['package_id', 'ip_address', 'viewed_on'], 'pkg_view_unique');
            $table->index(['package_id', 'viewed_on']);
            $table->index(['business_id', 'viewed_on']);
            $table->index('viewed_on');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_view');
    }
};
