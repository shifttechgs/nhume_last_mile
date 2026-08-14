<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // PostgreSQL foreign keys do not automatically create indexes.
        // These indexes eliminate full-table scans on the most common query patterns.

        Schema::table('users', function (Blueprint $table) {
            $table->index('role');          // WHERE role = 'sender' / 'admin' (every admin list view)
            $table->index('created_at');    // ORDER BY latest()
        });

        Schema::table('transporter_profiles', function (Blueprint $table) {
            $table->index('trust_tier');        // WHERE trust_tier = ? (dashboard counts, driver filters)
            $table->index('is_active');         // WHERE is_active = true (order create dropdown)
            $table->index('created_at');        // ORDER BY latest()
            // user_id FK — add explicit index since Postgres FK doesn't imply one
            $table->index('user_id');
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->index('status');             // WHERE status = ? / GROUP BY status
            $table->index('user_id');            // WHERE user_id = ? (sender dashboard)
            $table->index('assigned_driver_id'); // WHERE assigned_driver_id = ? (driver dashboard)
            $table->index('created_at');         // ORDER BY latest()
            // Composite: most sender queries filter user_id AND status
            $table->index(['user_id', 'status']);
            // Composite: driver queries filter assigned_driver_id AND status
            $table->index(['assigned_driver_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropIndex(['assigned_driver_id', 'status']);
            $table->dropIndex(['user_id', 'status']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['assigned_driver_id']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['status']);
        });

        Schema::table('transporter_profiles', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['is_active']);
            $table->dropIndex(['trust_tier']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
            $table->dropIndex(['role']);
        });
    }
};
