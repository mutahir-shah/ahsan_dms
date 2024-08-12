<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('payment_service');
            $table->string('payment_service_slug');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_services');
    }
}
