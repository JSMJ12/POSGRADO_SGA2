<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;
    protected $primaryKey = 'dni';
    protected $keyType = 'string';
    protected $fillable = [
        'nombre1',
        'nombre2',
        'apellidop',
        'apellidom',
        'dni',
        'estado_civil',
        'fecha_nacimiento',
        'provincia',
        'canton',
        'barrio',
        'direccion',
        'nacionalidad',
        'etnia',
        'email_personal',
        'email_institucional',
        'carnet_discapacidad',
        'tipo_discapacidad',
        'porcentaje_discapacidad',
        'contra',
        'image',
        'maestria_id'
    ];
    public function notas()
    {
        return $this->hasMany(Nota::class);
    }
    public function maestria()
    {
        return $this->belongsTo(Maestria::class);
    }
    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }
    
}
