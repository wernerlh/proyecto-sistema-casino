<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsistenciaEmpleado extends Model
{
    use HasFactory;

    protected $primaryKey = 'asistencia_id';
    protected $fillable = [
        'empleado_id', 'fecha', 'hora_entrada', 'hora_salida', 'horas_trabajadas',
        'tipo_jornada', 'estado', 'observaciones'
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }
}
