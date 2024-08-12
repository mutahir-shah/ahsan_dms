<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('payment_service_id')->nullable();
            $table->integer('provider_id')->nullable();
            $table->integer('user_id');
            $table->string('event_type');
            $table->string('tx_ref');
            $table->string('flw_ref');
            $table->string('order_ref');
            $table->string('amount');
            $table->string('charged_amount');
            $table->string('status');
            $table->string('currency');
            $table->string('customer_phone');
            $table->string('customer_fullname');
            $table->string('customer_email');
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
        Schema::dropIfExists('payment_histories');
    }
}
