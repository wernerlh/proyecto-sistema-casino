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
        Schema::create('empleados', function (Blueprint $table) {
            $table->id('empleado_id');
            $table->string('nombre', 100);
            $table->string('documento_identidad', 20)->unique();
            $table->string('correo', 100)->unique();
            $table->string('telefono', 15)->nullable();
            $table->enum('rol', ['ADMIN', 'DEALER', 'SOPORTE', 'SEGURIDAD', 'CAJERO']);
            $table->date('fecha_contratacion');
            $table->date('fecha_nacimiento');
            $table->enum('estado', ['ACTIVO', 'INACTIVO', 'VACACIONES', 'LICENCIA']);
            $table->decimal('salario_base', 10, 2);
            $table->unsignedBigInteger('supervisor_id')->nullable();
            $table->timestamps();

            $table->foreign('supervisor_id')->references('empleado_id')->on('empleados');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
