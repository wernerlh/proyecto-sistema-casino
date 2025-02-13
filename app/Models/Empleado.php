<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $primaryKey = 'empleado_id';
    protected $fillable = [
        'nombre_completo', 'documento_identidad', 'correo', 'telefono', 'rol',
        'fecha_contratacion', 'fecha_nacimiento', 'estado', 'salario_base', 'supervisor_id'
    ];

    public function supervisor()
    {
        return $this->belongsTo(Empleado::class, 'supervisor_id');
    }

    public function asistencias()
    {
        return $this->hasMany(AsistenciaEmpleado::class, 'empleado_id');
    }
}
