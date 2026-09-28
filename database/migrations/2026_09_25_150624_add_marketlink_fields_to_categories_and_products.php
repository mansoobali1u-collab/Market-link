<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        

        Schema::table('categories', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->text('description')->nullable()->after('name');
            $table->boolean('is_active')->default(true)->after('description');
        });

        

        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('farmer_id')
                ->after('id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('category_id')
                ->after('farmer_id')
                ->constrained('categories')
                ->cascadeOnDelete();

            $table->string('name')->after('category_id');

            $table->text('description')
                ->nullable()
                ->after('name');

            $table->decimal('price', 10, 2)
                ->after('description');

            $table->string('unit', 50)
                ->default('piece')
                ->after('price');

            $table->integer('stock_quantity')
                ->default(0)
                ->after('unit');

            $table->string('image')
                ->nullable()
                ->after('stock_quantity');

            $table->boolean('is_available')
                ->default(true)
                ->after('image');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['farmer_id']);
            $table->dropForeign(['category_id']);

            $table->dropColumn([
                'farmer_id',
                'category_id',
                'name',
                'description',
                'price',
                'unit',
                'stock_quantity',
                'image',
                'is_available',
            ]);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn([
                'name',
                'description',
                'is_active',
            ]);
        });
    }
};
