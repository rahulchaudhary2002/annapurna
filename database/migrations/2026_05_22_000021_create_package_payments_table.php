<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('package_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained()->cascadeOnDelete();
            $table->foreignId('business_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 10, 2);         // total paid
            $table->decimal('daily_rate', 8, 2);      // rate at time of payment
            $table->integer('days');                   // number of days purchased
            $table->date('paid_from');
            $table->date('paid_until');
            $table->string('payment_method')->nullable(); // cash, bank_transfer, esewa, khalti
            $table->string('reference')->nullable();       // transaction ID / receipt no
            $table->string('status')->default('paid');     // paid, pending, refunded
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['package_id', 'status']);
            $table->index(['business_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_payments');
    }
};
