<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transporter_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Source & service types
            $table->string('driver_source')->default('independent_transporter');
            $table->json('service_types')->default('["intercity_parcel"]');

            // Trust
            $table->string('trust_tier')->default('unverified');
            $table->text('trust_notes')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();

            // Location
            $table->foreignId('home_zone_id')->nullable()->constrained('service_zones')->nullOnDelete();

            // Profile
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->text('bio')->nullable();
            $table->string('avatar')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transporter_profiles');
    }
};
