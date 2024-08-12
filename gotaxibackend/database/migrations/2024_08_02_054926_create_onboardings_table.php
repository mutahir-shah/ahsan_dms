<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnboardingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('onboardings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('language_id');
            $table->string('title');
            $table->text('description');
            $table->string('type');
            $table->integer('parent_id');
            $table->integer('step');
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
        Schema::dropIfExists('onboardings');
    }
}
