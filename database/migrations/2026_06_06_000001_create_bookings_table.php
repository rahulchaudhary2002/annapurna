<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_number', 20)->unique();

            // Polymorphic: App\Models\Business (hotel) or App\Models\Package
            $table->morphs('bookable');

            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Guest details
            $table->string('guest_name');
            $table->string('guest_email');
            $table->string('guest_phone')->nullable();
            $table->unsignedSmallInteger('guests')->default(1);

            // Hotel-specific
            $table->date('check_in')->nullable();
            $table->date('check_out')->nullable();
            $table->unsignedSmallInteger('rooms')->nullable();

            // Package-specific
            $table->date('travel_date')->nullable();

            $table->text('special_requests')->nullable();

            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])
                ->default('pending');

            $table->decimal('total_price', 10, 2)->nullable();
            $table->text('admin_notes')->nullable();
            $table->string('ip_address', 45)->nullable();

            $table->timestamps();

            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
