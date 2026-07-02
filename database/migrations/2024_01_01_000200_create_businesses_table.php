<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // hotel, restaurant, travel_agency, guide, porter
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable(); // tagline like "Luxury & Comfort"
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('address')->nullable();
            $table->text('map_embed')->nullable();
            $table->string('cover_photo')->nullable(); // storage path
            $table->string('logo')->nullable(); // storage path
            $table->json('gallery')->nullable(); // array of storage paths
            $table->json('features')->nullable(); // array of feature strings
            $table->string('opening_hours')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('order')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('og_image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
