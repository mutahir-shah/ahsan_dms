<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('business_driver', function (Blueprint $table) {
            $table->unique([ 'platform_id', 'business_id' ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_driver', function (Blueprint $table) {
            $table->dropUnique([ 'platform_id', 'business_id' ]);
        });
    }
};
