<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('customer_id')
                ->after('id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->decimal('total_amount', 10, 2)
                ->default(0)
                ->after('customer_id');

            $table->string('status', 30)
                ->default('pending')
                ->after('total_amount');

            $table->dateTime('pickup_date')
                ->nullable()
                ->after('status');

            $table->string('pickup_time', 50)
                ->nullable()
                ->after('pickup_date');

            $table->text('notes')
                ->nullable()
                ->after('pickup_time');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->foreignId('order_id')
                ->after('id')
                ->constrained('orders')
                ->cascadeOnDelete();

            $table->foreignId('product_id')
                ->after('order_id')
                ->constrained('products')
                ->cascadeOnDelete();

            $table->foreignId('farmer_id')
                ->after('product_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->integer('quantity')
                ->default(1)
                ->after('farmer_id');

            $table->decimal('unit_price', 10, 2)
                ->default(0)
                ->after('quantity');

            $table->decimal('subtotal', 10, 2)
                ->default(0)
                ->after('unit_price');
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['product_id']);
            $table->dropForeign(['farmer_id']);

            $table->dropColumn([
                'order_id',
                'product_id',
                'farmer_id',
                'quantity',
                'unit_price',
                'subtotal',
            ]);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);

            $table->dropColumn([
                'customer_id',
                'total_amount',
                'status',
                'pickup_date',
                'pickup_time',
                'notes',
            ]);
        });
    }
};
