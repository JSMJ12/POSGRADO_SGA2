<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Alumno;
use App\Models\Nota;
use App\Models\Docente;

class DashboardAlumnoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $alumnoNombre = auth()->user()->name;
        $alumnoApellido = auth()->user()->apellido;
        $alumnoEmail = auth()->user()->email;
        $alumno = Alumno::where('nombre1', $alumnoNombre)
                ->where('apellidop', $alumnoApellido)
                ->where('email_institucional', $alumnoEmail)
                ->first();

        // Obtener las asignaturas matriculadas del alumno
        $matriculas = $alumno->matriculas;
        $asignaturas = [];

        foreach ($matriculas as $matricula) {
            $asignaturas[] = $matricula->asignatura;
        }
        // Obtener las notas del alumno en cada asignatura
        $notas = [];
        foreach ($asignaturas as $asignatura) {
            $asignatura->load('docentes');
            $nota = Nota::where('alumno_dni', $alumno->dni)
                        ->where('asignatura_id', $asignatura->id)
                        ->first();

            $docente = Docente::find($nota->docente_dni);
            $cohorte = $asignatura->cohortes()->with('aula')->first();
            $notas[$asignatura->nombre] = [
                'actividades_aprendizaje' => $nota->nota_actividades,
                'practicas_aplicacion' => $nota->nota_practicas,
                'aprendizaje_autonomo' => $nota->nota_autonomo,
                'examen_final' => $nota->examen_final,
                'recuperacion' => $nota->recuperacion,
                'total' => $nota->total,
                'aula' => $cohorte->aula->nombre,
                'paralelo' => $cohorte->aula->paralelo->nombre,
                'docente' => $docente->nombre1 . ' ' . $docente->nombre2 . ' ' . $docente->apellidop . ' ' . $docente->apellidom,
                'docente_image' => $docente->image
            ];
        }

        return view('dashboard.alumno', compact('asignaturas', 'notas', 'perPage'));
    }
}
