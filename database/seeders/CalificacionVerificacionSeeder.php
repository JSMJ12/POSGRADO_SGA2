<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Docente;
use App\Models\Nota;
use App\Models\CalificacionVerificacion;

class CalificacionVerificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $docentes = Docente::all();

        foreach ($docentes as $docente) {
            foreach ($docente->cohortes as $cohorte) {
                foreach ($cohorte->asignaturas as $asignatura) {
                    if ($docente->asignaturas->contains($asignatura)) {
                        $notaExistente = Nota::where([
                            'docente_dni' => $docente->dni,
                            'asignatura_id' => $asignatura->id,
                            'cohorte_id' => $cohorte->id,
                        ])->exists();

                        $calificacionVerificacion = new CalificacionVerificacion();
                        $calificacionVerificacion->docente_dni = $docente->dni;
                        $calificacionVerificacion->asignatura_id = $asignatura->id;
                        $calificacionVerificacion->cohorte_id = $cohorte->id;
                        
                        $calificacionVerificacion->calificado = $notaExistente;
                        $calificacionVerificacion->editar = !$notaExistente;

                        
                        $calificacionVerificacion->save();
                    }
                }
            }
        }
    }
}
