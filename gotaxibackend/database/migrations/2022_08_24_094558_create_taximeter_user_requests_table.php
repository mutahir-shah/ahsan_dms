<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaximeterUserRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taximeter_user_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('provider_id');
            $table->string('distance',500);
            $table->double('amount',10,2)->default('0.00');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taximeter_user_requests');
    }
}
