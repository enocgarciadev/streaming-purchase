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
        Schema::create('services', function (Blueprint $table) {
            $table->id(); // ID único para cada servicio
            $table->string('name'); // Nombre del servicio (ej. "Netflix Premium")
            $table->integer('number_of_profiles')->nullable(); // Número de perfiles permitidos, puede ser nulo
            $table->string('product_link')->nullable(); // Link directo al producto o servicio, puede ser nulo
            $table->timestamps(); // Columnas created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};