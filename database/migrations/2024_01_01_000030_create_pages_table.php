<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('pages')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('template')->default('default'); // default, home, about, contact, services, projects, blog, gallery, faq, pricing
            $table->longText('content')->nullable();
            $table->json('sections')->nullable(); // page builder sections
            $table->string('featured_image')->nullable();
            $table->string('status')->default('published'); // draft, published, scheduled
            $table->timestamp('published_at')->nullable();
            $table->boolean('show_in_sitemap')->default(true);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('og_image')->nullable();
            $table->string('og_type')->default('website');
            $table->boolean('no_index')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
