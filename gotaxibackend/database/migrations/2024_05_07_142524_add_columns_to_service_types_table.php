<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToServiceTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_types', function (Blueprint $table) {
            $table->tinyInteger('is_return_trip')->default(false);
            $table->decimal('return_trip_price_1', 10,2)->default(0);
            $table->decimal('return_trip_price_2', 10,2)->default(0);
            $table->decimal('return_trip_price_3', 10,2)->default(0);
            $table->decimal('return_trip_price_4', 10,2)->default(0);
            $table->decimal('peak_return_trip_price_1', 10,2)->default(0);
            $table->decimal('peak_return_trip_price_2', 10,2)->default(0);
            $table->decimal('peak_return_trip_price_3', 10,2)->default(0);
            $table->decimal('peak_return_trip_price_4', 10,2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_types', function (Blueprint $table) {
            $table->dropColumn('is_return_trip');
            $table->dropColumn('return_trip_price_1');
            $table->dropColumn('return_trip_price_2');
            $table->dropColumn('return_trip_price_3');
            $table->dropColumn('return_trip_price_4');
            $table->dropColumn('peak_return_trip_price_1');
            $table->dropColumn('peak_return_trip_price_2');
            $table->dropColumn('peak_return_trip_price_3');
            $table->dropColumn('peak_return_trip_price_4');
        });
    }
}
