<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsViewAllDataColumnToPrivilegesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('privileges', function (Blueprint $table) {
            $table->integer('is_view_all_data')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('privileges', function (Blueprint $table) {
            $table->dropColumn('is_view_all_data');
        });
    }
}
