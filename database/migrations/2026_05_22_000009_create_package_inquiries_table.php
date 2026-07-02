<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('package_inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->date('travel_date')->nullable();
            $table->unsignedSmallInteger('group_size')->nullable();
            $table->text('message')->nullable();
            $table->enum('status', ['new', 'read', 'responded'])->default('new');
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();

            $table->index(['package_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_inquiries');
    }
};
