<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trek_routes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('description')->nullable();
            $table->integer('duration_days')->nullable();
            $table->string('difficulty')->default('Moderate'); // Easy, Moderate, Strenuous
            $table->string('max_altitude')->nullable(); // e.g. "4,130 m"
            $table->string('total_distance')->nullable(); // e.g. "110 km"
            $table->string('start_point')->nullable();
            $table->string('end_point')->nullable();
            $table->string('best_season')->nullable();
            $table->json('itinerary')->nullable(); // [{day, title, description, altitude, distance}]
            $table->json('highlights')->nullable(); // array of strings
            $table->json('included_services')->nullable(); // array of strings
            $table->json('excluded_services')->nullable(); // array of strings
            $table->json('faqs')->nullable(); // [{question, answer}]
            $table->string('banner_image')->nullable(); // storage path - page header
            $table->string('featured_image')->nullable(); // storage path - card image
            $table->json('gallery')->nullable(); // array of storage paths
            $table->text('map_embed')->nullable();
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
        Schema::dropIfExists('trek_routes');
    }
};
