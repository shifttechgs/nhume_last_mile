<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('preferred_zone_id')->nullable()->constrained('service_zones')->nullOnDelete();
            $table->foreignId('shift_id')->nullable()->constrained('available_shifts')->nullOnDelete();

            $table->string('service_type');
            $table->string('status')->default('draft');

            // Pickup
            $table->string('pickup_address');
            $table->decimal('pickup_lat', 10, 7)->nullable();
            $table->decimal('pickup_lng', 10, 7)->nullable();

            // Dropoff
            $table->string('dropoff_address');
            $table->decimal('dropoff_lat', 10, 7)->nullable();
            $table->decimal('dropoff_lng', 10, 7)->nullable();

            // Item / errand details
            $table->string('item_description')->nullable();
            $table->decimal('weight_kg', 8, 2)->nullable();
            $table->text('errand_instructions')->nullable();

            $table->string('recipient_name')->nullable();
            $table->string('recipient_phone')->nullable();

            $table->decimal('offered_price', 10, 2)->nullable();
            $table->boolean('is_fragile')->default(false);

            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
