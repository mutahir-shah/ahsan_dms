<?php 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTrialEndTimeToProvidersAndUsersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->timestamp('trial_end_time')->nullable();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('trial_end_time')->nullable();
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
            $table->dropColumn('trial_end_time');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('trial_end_time');
        });
    }
}
