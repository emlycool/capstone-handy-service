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
        Schema::create('service_provider_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId("service_provider_id")->nullable()->constrained("users")->nullOnDelete();
            $table->foreignId("service_id")->nullable()->constrained("services")->nullOnDelete();
            $table->string("name");
            $table->text("description")->nullable();
            $table->json("included_benefits")->nullable();
            $table->string("price_model");
            $table->decimal("price")->nullable();
            $table->integer("duration_minutes")->nullable();
            $table->json("working_hours")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_provider_services');
    }
};
