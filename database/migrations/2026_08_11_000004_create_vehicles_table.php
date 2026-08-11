<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transporter_profile_id')->constrained()->cascadeOnDelete();
            $table->string('vehicle_type');
            $table->string('make')->nullable();
            $table->string('model')->nullable();
            $table->year('year')->nullable();
            $table->string('colour')->nullable();
            $table->string('registration_number')->nullable();
            $table->decimal('max_weight_kg', 8, 2)->nullable();
            $table->boolean('is_fleet_asset')->default(false);
            $table->boolean('is_primary')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
