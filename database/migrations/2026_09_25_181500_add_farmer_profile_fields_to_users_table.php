<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->string('business_name')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('market_name')->nullable();
            $table->string('operating_days')->nullable();
            $table->string('pickup_window')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([
                'business_name',
                'phone',
                'address',
                'market_name',
                'operating_days',
                'pickup_window',
                'latitude',
                'longitude',
            ]);

        });
    }
};
