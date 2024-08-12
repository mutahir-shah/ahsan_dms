<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('route')->nullable();
            $table->string('icon')->nullable();
             $table->integer('is_view')->default(1);
            $table->integer('is_add')->default(0);
            $table->integer('is_edit')->default(0);
            $table->integer('is_notify')->default(0);
            $table->integer('is_status')->default(0);
            $table->integer('is_delete')->default(0);
            $table->integer('type')->comment('1=Module, 2=Operation, 3=Text')->default(1);
            $table->integer('badged')->comment('0=false, 1=true')->default(0);
            $table->integer('parent')->default(0);
            $table->integer('sort')->default(0);
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
        Schema::dropIfExists('modules');
    }
}
