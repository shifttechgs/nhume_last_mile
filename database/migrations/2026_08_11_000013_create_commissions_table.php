<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->foreignId('payment_id')->nullable()->constrained()->nullOnDelete();

            $table->decimal('gross_amount', 10, 2);
            $table->decimal('commission_rate', 5, 4);
            $table->decimal('commission_amount', 10, 2);
            $table->decimal('transporter_payout', 10, 2);

            $table->string('status')->default('pending');
            $table->timestamp('paid_out_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
};
