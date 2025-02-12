<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $primaryKey = 'cliente_id'; // Define la clave primaria
    protected $fillable = [
        'nombre_completo',
        'correo',
        'telefono',
        'direccion',
        'fecha_nacimiento',
        'fecha_registro',
        'preferencias',
        'estado_membresia',
        'documento_identidad',
        'limite_apuesta_diario',
    ];

    protected $casts = [
        'preferencias' => 'array', // Convierte el campo JSON a array
        'fecha_nacimiento' => 'date', // Convierte el campo a tipo fecha
        'fecha_registro' => 'datetime', // Convierte el campo a tipo datetime
    ];
}
