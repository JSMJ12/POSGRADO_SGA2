<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nota;
use App\Models\Asignatura;
use App\Models\Alumno;
use App\Models\Matricula;

class NotaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index($alumno_dni)
    {
        if (strlen($alumno_dni) === 9) {
            $alumno_dni = '0' . $alumno_dni;
        }
        $alumno = Alumno::find($alumno_dni);
        $notas = Nota::where('alumno_dni', $alumno_dni)->with('asignatura')->get();

        return view('notas.index', compact('alumno', 'notas'));
    }

    public function create($alumno_dni)
    {
        if (strlen($alumno_dni) === 9) {
            $alumno_dni = '0' . $alumno_dni;
        }
        // Obtener el alumno y sus matriculas
        $alumno = Alumno::findOrFail($alumno_dni);
        $matriculas = $alumno->matriculas;

        // Obtener las asignaturas de las matriculas del alumno
        $asignaturas = collect();
        foreach ($matriculas as $matricula) {
            $cohorte = $matricula->cohorte;
            $asignaturas = $asignaturas->merge($cohorte->asignaturas);
        }

        return view('notas.create', compact('alumno', 'asignaturas'));
    }
    public function store(Request $request)
    {
            
        // Obtener los datos enviados desde el formulario
        $alumno_dni = $request->input('alumno_dni');
        if (strlen($alumno_dni) === 9) {
            $alumno_dni = '0' . $alumno_dni;
        }
        $notas_actividades = $request->input('nota_actividades');
        $notas_practicas = $request->input('nota_practicas');
        $notas_autonomo = $request->input('nota_autonomo');
        $examenes_finales = $request->input('examen_final');
        $recuperaciones = $request->input('recuperacion');
        $totales = $request->input('total');


        // Iterar sobre las notas de las asignaturas y guardarlas en la base de datos
        foreach ($notas_actividades as $asignatura_id => $nota_actividades) {
            $nota = new Nota();
            $nota->alumno_dni = $alumno_dni;
            $alumno = Alumno::findOrFail($alumno_dni);
            $nota->asignatura_id = $asignatura_id;
            $asignatura = Asignatura::findOrFail($asignatura_id);
            $docente_dni = $asignatura->docentes->first()->dni;
            if (strlen($docente_dni) === 9) {
                $docente_dni = '0' . $docente_dni;
            }
            $nota->docente_dni = $docente_dni;
            $matricula = Matricula::where('alumno_dni', $alumno_dni)
                ->where('asignatura_id', $asignatura_id)
                ->whereHas('cohorte', function($query) use ($docente_dni) {
                    $query->where('docente_dni', $docente_dni);
                })
                ->firstOrFail();

            // Obtener el cohorte correspondiente
            $cohorte = $matricula->cohorte;
            $nota->cohorte_id = $cohorte->id;
            $nota->nota_actividades = $nota_actividades;
            $nota->nota_practicas = $notas_practicas[$asignatura_id];
            $nota->nota_autonomo = $notas_autonomo[$asignatura_id];
            $nota->examen_final = $examenes_finales[$asignatura_id];
            $nota->recuperacion = $recuperaciones[$asignatura_id];
            $nota->total = $totales[$asignatura_id];
            $nota->save();
        }


        return redirect()->route('notas.index', ['id_alumno' => $alumno_dni])->with('success', 'Notas guardadas exitosamente');
    }
    public function destroy($id)
    {
        $nota = Nota::findOrFail($id);
        $nota->delete();
        return redirect()->route('notas.index')
            ->with('success', 'Nota eliminada exitosamente.');
    }
}

