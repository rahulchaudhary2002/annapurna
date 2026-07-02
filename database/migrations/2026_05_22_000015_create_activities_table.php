<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('category')->nullable(); // water, air, land, cultural
            $table->string('difficulty')->nullable(); // easy, moderate, hard, extreme
            $table->string('duration')->nullable(); // e.g. "2-3 hours", "Full Day"
            $table->decimal('price_from', 10, 2)->nullable();
            $table->string('best_season')->nullable(); // e.g. "Oct–Nov, Mar–Apr"
            $table->json('photos')->nullable();
            $table->json('highlights')->nullable();
            $table->json('inclusions')->nullable();
            $table->json('exclusions')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->unsignedSmallInteger('order')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();

            $table->index(['is_active', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
