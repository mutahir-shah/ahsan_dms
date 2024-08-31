<?php

use App\Models\{Branch, Country, Department, Designation, EmploymentType, Language, Role};
use App\Enums\{Salutation, Gender, MaritalStatus};
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Designation::class)->constrained();
            $table->foreignIdFor(Department::class)->constrained();
            $table->foreignIdFor(Role::class)->constrained();
            $table->foreignIdFor(EmploymentType::class)->constrained();
            $table->foreignIdFor(Branch::class)->constrained();
            $table->foreignIdFor(Country::class)->constrained();
            $table->foreignIdFor(Language::class)->constrained();
            $table->string('user_id')->nullable();
            $table->enum('salutation', array_column(Salutation::cases(), 'value'))->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->text('image')->nullable();
            $table->string('password')->nullable();
            $table->string('mobile')->nullable();
            $table->enum('gender', array_column(Gender::cases(), 'value'))->default(Gender::Male);
            $table->date('dob')->nullable();
            $table->date('joining_date')->nullable();
            $table->unsignedBigInteger('reporting_to')->nullable();
            $table->foreign('reporting_to')->references('id')->on('users')->nullOnDelete();
            $table->longText('address')->nullable();
            $table->longText('about')->nullable();
            $table->boolean('is_login_allowed')->default(true);
            $table->boolean('is_receive_email_notification')->default(true);
            $table->decimal('hourly_rate', 8,2)->nullable()->default(0);
            $table->string('slack_memember_id')->nullable();
            $table->string('skills')->nullable();
            $table->date('probation_end_date')->nullable();
            $table->date('notice_period_start_date')->nullable();
            $table->date('notice_period_end_date')->nullable();
            $table->enum('marital_status', array_column(MaritalStatus::cases(), 'value'))->default(MaritalStatus::Single);
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
