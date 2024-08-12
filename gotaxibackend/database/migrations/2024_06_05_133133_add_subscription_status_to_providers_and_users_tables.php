<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubscriptionStatusToProvidersAndUsersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->string('subscription_status')->nullable();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('subscription_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->dropColumn('subscription_status');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('subscription_status');
        });
    }
}
