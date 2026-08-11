<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('journeys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_id')->constrained()->cascadeOnDelete();
            $table->foreignId('transporter_profile_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vehicle_id')->nullable()->constrained()->nullOnDelete();

            $table->string('status')->default('draft');
            $table->string('source')->default('transporter_direct');

            $table->dateTime('departs_at');
            $table->dateTime('arrives_at')->nullable();

            $table->decimal('available_weight_kg', 8, 2)->nullable();
            $table->unsignedSmallInteger('available_slots')->default(1);
            $table->decimal('price_per_kg', 8, 2)->nullable();
            $table->decimal('min_price', 8, 2)->nullable();

            $table->text('notes')->nullable();

            // Admin draft support (from CLAUDE.md)
            $table->foreignId('admin_draft_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journeys');
    }
};
