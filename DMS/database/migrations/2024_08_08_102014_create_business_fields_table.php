<?php

use App\Enums\FieldsTypes;
use App\Models\Business;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Guid\Fields;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('business_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Business::class)->constrained();
            $table->string('name', 255)->nullable();
            $table->enum('type', array_column(FieldsTypes::cases(), 'value'))->default(FieldsTypes::TEXT);
            $table->boolean('required')->default(true);
            $table->boolean('admin_only')->default(false);
            $table->softDeletes();
            $table->timestamps();

        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_fields');
    }
};
