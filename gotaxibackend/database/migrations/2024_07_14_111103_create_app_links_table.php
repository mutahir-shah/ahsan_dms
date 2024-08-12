<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_links', function (Blueprint $table) {
            $table->increments('id');
            $table->string('f_u_url')->nullable();
            $table->string('f_p_url')->nullable();
            $table->string('user_store_link_ios')->nullable();
            $table->string('driver_store_link_ios')->nullable();
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
        Schema::dropIfExists('app_links');
    }
}
