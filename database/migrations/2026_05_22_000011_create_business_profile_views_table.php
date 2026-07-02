<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('business_profile_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('ip_address', 45)->nullable();
            $table->date('viewed_on'); // deduplicate per IP per day
            $table->timestamp('created_at')->useCurrent();

            $table->unique(['business_id', 'ip_address', 'viewed_on'], 'bpv_unique_daily');
            $table->index(['business_id', 'viewed_on']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('business_profile_views');
    }
};
