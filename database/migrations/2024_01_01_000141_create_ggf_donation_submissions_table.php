<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ggf_donation_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('amount');
            $table->string('screenshot')->nullable();
            $table->string('status')->default('new'); // new, reviewed, confirmed, rejected
            $table->text('admin_notes')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ggf_donation_submissions');
    }
};
