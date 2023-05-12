<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'fecha_ini',
        'fecha_fin',
        'hr_inicio',
        'hr_final',
        'descripcion',
        'long',
        'lat',
        'host_id',
        'tipo_id',
        'asistentes',
        'nombre',
        'address',
        'invite_code',
    ];
}
