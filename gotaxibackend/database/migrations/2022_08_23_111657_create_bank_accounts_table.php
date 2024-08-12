<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('paypal_id',1000)->nullable();
            $table->string('stripe_id',255)->nullable();
            $table->string('upi_id',1000)->nullable();
            $table->string('account_name',1000)->nullable();
            $table->string('type',100)->nullable();
            $table->string('bank_name',100)->nullable();
            $table->string('account_number',1000)->nullable();
            $table->string('IFSC_code',1000)->nullable();
            $table->string('MICR_code',1000)->nullable();
            $table->integer('routing_number')->nullable();
            $table->integer('provider_id');
            $table->enum('account_type',['Rider','Driver'])->nullable()->default('Driver');
            $table->enum('status',['WAITING','APPROVED'])->default('WAITING');
            $table->string('country',100)->nullable();
            $table->string('currency',100)->nullable();
            // $table->timestamps();
            // $table->index('provider_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_accounts');
    }
}
