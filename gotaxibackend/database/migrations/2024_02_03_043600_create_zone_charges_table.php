<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZoneChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zone_charges', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->enum('type', [ 'TOLL_CHARGE', 'AIRPORT_SURCHARGE', 'ADDITIONAL_CHARGE' ]);
            $table->enum('charge_type', [ 'PERCENTAGE', 'FIXED' ])->default('FIXED');
            $table->double('charge_value')->default(0);
            $table->integer('zone_id');
            $table->foreign('zone_id')->references('id')->on('zones');
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
        Schema::dropIfExists('zone_charges');
    }
}
