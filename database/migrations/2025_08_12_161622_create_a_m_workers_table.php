<?php

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
        Schema::create('am_workers', function (Blueprint $table) {
            $table->id();
            $table->string('personnel_number');
            $table->date('birthdate')->nullable();
            $table->string('citizenship_country_region')->nullable();
            $table->date('deceased_date')->nullable();
            $table->date('disabled_verification_date')->nullable();
            $table->string('education')->nullable();
            $table->string('ethnic_origin_id')->nullable();
            $table->string('first_name');
            $table->enum('gender', ['Male', 'Female'])->nullable();
            $table->boolean('is_disabled')->default(false);
            $table->boolean('is_full_time_student')->default(false);
            $table->string('known_as')->nullable();
            $table->string('language_id')->nullable();
            $table->string('last_name');
            $table->string('last_name_prefix')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('name');
            $table->string('nationality_country_region')->nullable();
            $table->string('native_language_id')->nullable();
            $table->string('personal_suffix')->nullable();
            $table->string('personal_title')->nullable();
            $table->string('person_birth_city')->nullable();
            $table->string('person_birth_country_region')->nullable();
            $table->string('primary_contact_email')->nullable();
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->timestamps();
            
            // Ensure unique personnel number per tenant
            $table->unique(['personnel_number', 'tenant_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('am_workers');
    }
};
