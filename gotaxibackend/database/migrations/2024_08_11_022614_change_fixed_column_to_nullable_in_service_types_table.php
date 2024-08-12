<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ChangeFixedColumnToNullableInServiceTypesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Change the column to be nullable
        DB::statement('ALTER TABLE service_types MODIFY fixed DECIMAL(8,2) NULL');
        DB::statement('ALTER TABLE service_types MODIFY price DECIMAL(8,2) NULL DEFAULT 0.00');
        DB::statement('ALTER TABLE service_types MODIFY minute DECIMAL(8,2) NULL  DEFAULT 0.00');
        DB::statement('ALTER TABLE service_types MODIFY distance DECIMAL(8,2) NULL DEFAULT 0.00');
        DB::statement('ALTER TABLE service_types MODIFY service_time_duration INT  DEFAULT 0');
        
        DB::statement('ALTER TABLE service_types MODIFY apply_after_1 DECIMAL(8,2) NULL');
        DB::statement('ALTER TABLE service_types MODIFY apply_after_2 DECIMAL(8,2) NULL');
        DB::statement('ALTER TABLE service_types MODIFY apply_after_3 DECIMAL(8,2) NULL');
        DB::statement('ALTER TABLE service_types MODIFY apply_after_4 DECIMAL(8,2) NULL');
        DB::statement('ALTER TABLE service_types MODIFY peak_after_1_price DECIMAL(8,2) NULL');
        DB::statement('ALTER TABLE service_types MODIFY peak_after_2_price DECIMAL(8,2) NULL');
        DB::statement('ALTER TABLE service_types MODIFY peak_after_3_price DECIMAL(8,2) NULL');
        DB::statement('ALTER TABLE service_types MODIFY peak_after_4_price DECIMAL(8,2) NULL');
        DB::statement('ALTER TABLE service_types MODIFY peak_apply_after_1 DECIMAL(8,2) NULL');
        DB::statement('ALTER TABLE service_types MODIFY peak_apply_after_2 DECIMAL(8,2) NULL');
        DB::statement('ALTER TABLE service_types MODIFY peak_apply_after_3 DECIMAL(8,2) NULL');
        DB::statement('ALTER TABLE service_types MODIFY peak_apply_after_4 DECIMAL(8,2) NULL');
        DB::statement('ALTER TABLE service_types MODIFY peak_return_trip_price_1 DECIMAL(8,2) NULL');
        DB::statement('ALTER TABLE service_types MODIFY peak_return_trip_price_2 DECIMAL(8,2) NULL');
        DB::statement('ALTER TABLE service_types MODIFY peak_return_trip_price_3 DECIMAL(8,2) NULL');
        DB::statement('ALTER TABLE service_types MODIFY peak_return_trip_price_4 DECIMAL(8,2) NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert the column to NOT NULL
        DB::statement('ALTER TABLE service_types MODIFY fixed DECIMAL(8,2) NOT NULL');
        DB::statement('ALTER TABLE service_types MODIFY price DECIMAL(8,2) NULL');
        DB::statement('ALTER TABLE service_types MODIFY minute DECIMAL(8,2) NULL');
        DB::statement('ALTER TABLE service_types MODIFY distance DECIMAL(8,2) NULL');
        DB::statement('ALTER TABLE service_types MODIFY service_time_duration INT');

        DB::statement('ALTER TABLE service_types MODIFY apply_after_1 DECIMAL(8,2) DEFAULT 0.00');
        DB::statement('ALTER TABLE service_types MODIFY apply_after_2 DECIMAL(8,2) DEFAULT 0.00');
        DB::statement('ALTER TABLE service_types MODIFY apply_after_3 DECIMAL(8,2) DEFAULT 0.00');
        DB::statement('ALTER TABLE service_types MODIFY apply_after_4 DECIMAL(8,2) DEFAULT 0.00');
        DB::statement('ALTER TABLE service_types MODIFY peak_after_1_price DECIMAL(8,2) DEFAULT 0.00');
        DB::statement('ALTER TABLE service_types MODIFY peak_after_2_price DECIMAL(8,2) DEFAULT 0.00');
        DB::statement('ALTER TABLE service_types MODIFY peak_after_3_price DECIMAL(8,2) DEFAULT 0.00');
        DB::statement('ALTER TABLE service_types MODIFY peak_after_4_price DECIMAL(8,2) DEFAULT 0.00');
        DB::statement('ALTER TABLE service_types MODIFY peak_apply_after_1 DECIMAL(8,2) DEFAULT 0.00');
        DB::statement('ALTER TABLE service_types MODIFY peak_apply_after_2 DECIMAL(8,2) DEFAULT 0.00');
        DB::statement('ALTER TABLE service_types MODIFY peak_apply_after_3 DECIMAL(8,2) DEFAULT 0.00');
        DB::statement('ALTER TABLE service_types MODIFY peak_apply_after_4 DECIMAL(8,2) DEFAULT 0.00');
        DB::statement('ALTER TABLE service_types MODIFY peak_return_trip_price_1 DECIMAL(8,2) DEFAULT 0.00');
        DB::statement('ALTER TABLE service_types MODIFY peak_return_trip_price_2 DECIMAL(8,2) DEFAULT 0.00');
        DB::statement('ALTER TABLE service_types MODIFY peak_return_trip_price_3 DECIMAL(8,2) DEFAULT 0.00');
        DB::statement('ALTER TABLE service_types MODIFY peak_return_trip_price_4 DECIMAL(8,2) DEFAULT 0.00');
    }
}
