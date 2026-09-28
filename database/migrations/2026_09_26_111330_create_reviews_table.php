<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

public function up()
{
    Schema::create('reviews', function (Blueprint $table) {
        $table->id('review_id');
        $table->foreignId('product_id')->constrained('products', 'product_id')->onDelete('cascade');
        $table->foreignId('customer_id')->constrained('users', 'user_id')->onDelete('cascade');
        $table->unsignedTinyInteger('rating'); // 1-5
        $table->text('comment')->nullable();
        $table->text('farmer_response')->nullable();
        $table->timestamp('farmer_response_at')->nullable();
        $table->timestamp('review_date')->useCurrent();
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('reviews');
}
};
