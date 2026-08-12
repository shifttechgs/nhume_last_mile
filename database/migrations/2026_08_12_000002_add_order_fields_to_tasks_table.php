<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->string('order_number')->unique()->nullable()->after('id');
            $table->string('pickup_type')->default('walk_in')->after('service_type');
            $table->string('order_source')->default('online')->after('pickup_type');
            $table->string('package_category')->nullable()->after('item_description');
            $table->foreignId('collection_point_id')->nullable()->after('preferred_zone_id')
                  ->constrained('collection_points')->nullOnDelete();
            $table->decimal('price_estimate', 10, 2)->nullable()->after('offered_price');
            $table->timestamp('scheduled_at')->nullable()->after('price_estimate');
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['collection_point_id']);
            $table->dropColumn([
                'order_number', 'pickup_type', 'order_source',
                'package_category', 'collection_point_id',
                'price_estimate', 'scheduled_at',
            ]);
        });
    }
};
