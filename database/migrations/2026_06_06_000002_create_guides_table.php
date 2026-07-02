<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guides', function (Blueprint $table) {
            $table->id();

            // Optional link to a registered user account
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('photo')->nullable();

            $table->text('bio')->nullable();
            $table->text('short_bio')->nullable();

            // JSON arrays
            $table->json('specializations')->nullable(); // ["Annapurna Circuit", "ABC Trek"]
            $table->json('languages')->nullable();       // ["English", "Nepali", "French"]
            $table->json('certifications')->nullable();  // ["TAAN Certified", "First Aid"]

            $table->unsignedSmallInteger('experience_years')->default(0);
            $table->unsignedInteger('total_treks')->default(0);
            $table->decimal('rating', 3, 1)->default(0);

            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->unsignedSmallInteger('order')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guides');
    }
};
