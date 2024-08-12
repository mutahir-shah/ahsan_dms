<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateServiceTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `service_types` CHANGE `type` `type` ENUM('daily','economy','luxury','extra_seat','outstation','road_assistance','dream_driver','rental','personal_care','medical_health','education_training','consulting','cleaning_services','maintenance','construction','security','landscaping','garden','outdoor_construction','exterior_design') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'economy'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE `service_types` CHANGE `type` `type` ENUM('daily','economy','luxury','extra_seat','outstation','road_assistance','dream_driver','rental') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'economy'");
    }
}
