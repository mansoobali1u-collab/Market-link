<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

  public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->foreignId('market_id')->nullable()->after('id')->constrained('markets')->nullOnDelete();
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['market_id']);
        $table->dropColumn('market_id');
    });
    }
};
