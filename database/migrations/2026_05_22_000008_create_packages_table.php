<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('price', 10, 2);
            $table->string('duration');
            $table->unsignedSmallInteger('duration_days')->default(1);
            $table->json('highlights')->nullable();
            $table->json('itinerary')->nullable();
            $table->json('photos')->nullable();
            $table->string('video_url')->nullable();
            $table->json('faqs')->nullable();
            $table->text('map_embed')->nullable();
            $table->boolean('is_active')->default(true);
            $table->enum('listing_type', ['free', 'paid'])->default('free');
            $table->timestamp('paid_from')->nullable();
            $table->timestamp('paid_until')->nullable();
            $table->decimal('daily_rate', 8, 2)->nullable();
            $table->unsignedSmallInteger('order')->default(0);
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->timestamps();

            $table->index(['is_active', 'listing_type']);
            $table->index(['listing_type', 'paid_until']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
