<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pricing_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('badge')->nullable(); // "Most Popular", "Best Value"
            $table->decimal('price_monthly', 10, 2)->default(0);
            $table->decimal('price_yearly', 10, 2)->default(0);
            $table->string('currency')->default('USD');
            $table->string('currency_symbol')->default('$');
            $table->json('features')->nullable(); // [{"text": "...", "included": true/false}]
            $table->string('button_text')->default('Get Started');
            $table->string('button_url')->nullable();
            $table->string('color')->nullable(); // highlight color
            $table->boolean('is_featured')->default(false); // highlighted plan
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pricing_plans');
    }
};
