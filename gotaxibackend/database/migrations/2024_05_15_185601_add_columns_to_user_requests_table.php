<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToUserRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_requests', function (Blueprint $table) {
            $table->decimal('return_amount',10,2)->default(0);
            $table->decimal('return_ride_amount',10,2)->default(0);
            $table->decimal('return_driver_amount',10,2)->default(0);
            $table->boolean('is_return_trip_applied')->default(0);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_requests', function (Blueprint $table) {
            $table->dropColumn('amount');
            $table->dropColumn('return_ride_amount');
            $table->dropColumn('return_driver_amount');
            $table->dropColumn('is_return_trip_applied');
        });
    }
}
