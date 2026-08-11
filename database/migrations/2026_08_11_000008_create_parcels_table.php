<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parcels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('route_id')->nullable()->constrained()->nullOnDelete();

            $table->string('status')->default('draft');

            $table->string('parcel_type')->nullable();
            $table->text('description')->nullable();
            $table->decimal('weight_kg', 8, 2)->nullable();

            $table->string('recipient_name');
            $table->string('recipient_phone');
            $table->string('pickup_address')->nullable();
            $table->string('dropoff_address')->nullable();

            $table->decimal('offered_price', 10, 2)->nullable();
            $table->boolean('is_fragile')->default(false);
            $table->boolean('requires_signature')->default(false);

            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parcels');
    }
};
