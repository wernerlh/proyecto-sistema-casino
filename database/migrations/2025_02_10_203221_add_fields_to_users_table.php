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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('empleado_id')->nullable()->after('id');
            $table->string('rol')->default('USER')->after('email');
            $table->timestamp('ultimo_ingreso')->nullable()->after('rol');

            $table->foreign('empleado_id')->references('empleado_id')->on('empleados')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['empleado_id']);
            $table->dropColumn(['empleado_id', 'rol', 'ultimo_ingreso']);
        });
    }
};