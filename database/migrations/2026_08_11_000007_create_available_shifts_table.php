<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('available_shifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transporter_profile_id')->constrained()->cascadeOnDelete();
            $table->foreignId('service_zone_id')->constrained()->cascadeOnDelete();

            // JSON array of service_type values the rider will accept this shift
            $table->json('service_types')->default('["last_mile_delivery"]');

            $table->dateTime('starts_at');
            $table->dateTime('ends_at');
            $table->string('status')->default('scheduled');
            $table->unsignedTinyInteger('max_concurrent_tasks')->default(1);

            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('available_shifts');
    }
};
