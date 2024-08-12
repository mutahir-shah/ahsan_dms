<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRequestZoneChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_requests_zone_charge', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_requests_id');
            $table->unsignedInteger('zone_charge_id');
            $table->double('charge_value');
            $table->foreign('zone_charge_id')->references('id')->on('zone_charges');
            $table->foreign('user_requests_id')->references('id')->on('user_requests');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_request_zone_charge');
    }
}
