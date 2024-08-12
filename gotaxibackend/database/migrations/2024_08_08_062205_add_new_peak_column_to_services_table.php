<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewPeakColumnToServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_types', function (Blueprint $table) {
            $table->integer('peak1')->default(0);
            $table->integer('peak2')->default(0);
            $table->integer('peak3')->default(0);
            $table->time('phourfromone')->nullable();
            $table->time('phourtoone')->nullable();
            $table->time('phourfromtwo')->nullable();
            $table->time('phourtotwo')->nullable();
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
            $table->dropColumn(['phourfromone','phourtoone','phourfromtwo', 'phourtotwo', 'peak1', 'peak2', 'peak3']);
        });
    }
}
