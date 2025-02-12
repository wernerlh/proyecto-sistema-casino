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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id('cliente_id');
            $table->string('nombre_completo', 200); // Combina nombre y apellido
            $table->string('correo', 100)->unique();
            $table->string('telefono', 15)->nullable();
            $table->string('direccion', 200)->nullable();
            $table->date('fecha_nacimiento');
            $table->dateTime('fecha_registro')->useCurrent();
            $table->json('preferencias')->nullable();
            $table->string('estado_membresia', 50)->default('desactivado'); // Cambiado a 'desactivado'
            $table->string('documento_identidad', 20)->unique();
            $table->decimal('limite_apuesta_diario', 10, 2)->default(1000); // Valor por defecto: 1000
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
