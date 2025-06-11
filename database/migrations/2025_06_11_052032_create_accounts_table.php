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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete(); // Relación con la tabla 'services'
            $table->string('email')->unique(); // Correo de la cuenta (único)
            $table->string('password'); // Contraseña de la cuenta (hash en lo posible, o en texto plano si sabes lo que haces, pero se recomienda hashear)
            $table->date('billing_date'); // Fecha de facturación
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};