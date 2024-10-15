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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained("users", "id")->nullOnDelete();
            $table->foreignId('service_provider_id')->nullable()->constrained("users", "id")->nullOnDelete();
            $table->foreignId('service_id')->nullable()->constrained("services", "id")->nullOnDelete();
            $table->foreignId('provider_service_id')->nullable()->constrained("service_provider_services", "id")->nullOnDelete();
            $table->string("status")->default("pending");
            $table->text("notes")->nullable();
            $table->timestamp("appointment_start_date");
            $table->timestamp("appointment_end_date");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
