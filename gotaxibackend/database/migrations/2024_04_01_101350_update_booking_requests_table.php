<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBookingRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_requests', function (Blueprint $table) {
            $table->string('special_note')->nullable();
            $table->string('email')->nullable();
            $table->string('vehicle_model')->nullable();
            $table->string('vehicle_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_requests', function (Blueprint $table) {
            $table->dropColumn('special_note', 'email', 'vehicle_model', 'vehicle_number');
        });
    }
}
