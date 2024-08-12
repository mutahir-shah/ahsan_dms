<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComplaintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50)->nullable();
            $table->string('email',100)->nullable();
            $table->string('phone',50)->nullable();
            $table->string('subject',100)->nullable();
            $table->string('message')->nullable();
            $table->string('attachmennt')->nullable();
            $table->string('type',50)->nullable();
            $table->integer('transfer')->nullable();
            $table->integer('status')->nullable();
            

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
        Schema::dropIfExists('complaints');
    }
}
