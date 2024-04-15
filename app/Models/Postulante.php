<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postulante extends Model
{
    use HasFactory;
    protected $table = 'postulantes';
    protected $primaryKey = 'dni';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'dni',
        'apellidop',
        'apellidom',
        'nombre1',
        'nombre2',
        'correo_electronico',
        'celular',
        'titulo_profesional',
        'universidad_titulo',
        'sexo',
        'fecha_nacimiento',
        'nacionalidad',
        'discapacidad',
        'porcentaje_discapacidad',
        'codigo_conadis',
        'provincia',
        'etnia',
        'nacionalidad_indigena',
        'canton',
        'direccion',
        'tipo_colegio',
        'cantidad_miembros_hogar',
        'ingreso_total_hogar',
        'nivel_formacion_padre',
        'nivel_formacion_madre',
        'origen_recursos_estudios',
        'imagen',
        'pdf_cedula',
        'pdf_papelvotacion',
        'pdf_titulouniversidad',
        'pdf_conadis',
        'maestria_id',
    ];
    public function maestria()
    {
        return $this->belongsTo(Maestria::class, 'maestria_id');
    }

}
