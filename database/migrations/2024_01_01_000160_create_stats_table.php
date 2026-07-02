<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Counter/stats displayed on about/home pages
        Schema::create('counters', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('value'); // "500+", "10K", etc.
            $table->integer('numeric_value')->default(0); // for animation counting
            $table->string('suffix')->nullable(); // "+", "K", "%"
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Partners/clients logos
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo');
            $table->string('url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Popup/announcement banners
        Schema::create('popups', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content')->nullable();
            $table->string('image')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_url')->nullable();
            $table->string('position')->default('center'); // center, bottom-left, bottom-right
            $table->boolean('show_once')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('popups');
        Schema::dropIfExists('partners');
        Schema::dropIfExists('counters');
    }
};
