<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nota;
use App\Models\Matricula;
use App\Models\Docente;
use App\Models\CalificacionVerificacion;
use App\Models\Cohorte;
class CalificacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function create($docente_dni, $asignatura_id, $cohorte_id)
    {
        $matriculas = Matricula::where('docente_dni', $docente_dni)
                                ->where('asignatura_id', $asignatura_id)
                                ->where('cohorte_id', $cohorte_id)
                                ->get();
        $alumnos = collect([]);
        foreach ($matriculas as $matricula) {
            $alumnos->push($matricula->alumno);
        }
        return view('calificaciones.create', compact('alumnos', 'docente_dni', 'asignatura_id', 'cohorte_id'));
    }
    public function store(Request $request)
    {
        $docenteDni = $request->input('docente_dni');
        $asignaturaId = $request->input('asignatura_id');
        $cohorteId = $request->input('cohorte_id');
        $alumnoDnis = $request->input('alumno_dni');
        $notasActividades = $request->input('nota_actividades');
        $notasPracticas = $request->input('nota_practicas');
        $notasAutonomo = $request->input('nota_autonomo');
        $examenesFinales = $request->input('examen_final');
        $recuperaciones = $request->input('recuperacion');
        $totales = $request->input('total');
        
        foreach ($alumnoDnis as $alumnoId) {
            $calificacion = Nota::updateOrCreate(
                ['docente_dni' => $docenteDni, 'alumno_dni' => $alumnoId, 'asignatura_id' => $asignaturaId, 'cohorte_id' => $cohorteId],
                [
                    'docente_dni' => $docenteDni,
                    'alumno_dni' => $alumnoId,
                    'nota_actividades' => $notasActividades[$alumnoId] ?? null,
                    'nota_practicas' => $notasPracticas[$alumnoId] ?? null,
                    'nota_autonomo' => $notasAutonomo[$alumnoId] ?? null,
                    'examen_final' => $examenesFinales[$alumnoId] ?? null,
                    'recuperacion' => $recuperaciones[$alumnoId] ?? null,
                    'total' => $totales[$alumnoId] ?? null,
                    'asignatura_id' => $asignaturaId,
                    'cohorte_id' => $cohorteId,
                ]
            );
        }

        $docenteNombre = auth()->user()->name;
        $docenteApellido = auth()->user()->apellido;
        $docenteEmail = auth()->user()->email;
        $docente = Docente::where('nombre1', $docenteNombre)
                        ->where('apellidop', $docenteApellido)
                        ->where('email', $docenteEmail)
                        ->first();
        // 
        $docente_dni = $docente->dni;
        $asignaturas = $docente->asignaturas;

        // Obtener los alumnos matriculados en las asignaturas del docente
        $alumnos = collect();
        foreach ($asignaturas as $asignatura) {
            $matriculas = $asignatura->matriculas;
            foreach ($matriculas as $matricula) {
                $alumno = $matricula->alumno;
                $alumnos->push($alumno);
            }
        }
                    
        return redirect()->route('dashboard_docente')->with('success', 'Calificaciones almacenadas exitosamente');
    }
    public function edit($alumno_dni, $docente_dni, $asignatura_id, $cohorte_id)
    {
        // Obtener la instancia de CalificacionVerificacion
        $calificacionVerificacion = CalificacionVerificacion::where('docente_dni', $docente_dni)
            ->where('asignatura_id', $asignatura_id)
            ->where('cohorte_id', $cohorte_id)
            ->first();

        // Verificar si el usuario tiene permiso de edición
        $tienePermisoEditar = $calificacionVerificacion ? $calificacionVerificacion->editar : false;

        // Obtener la nota correspondiente
        $nota = Nota::where('cohorte_id', $cohorte_id)
            ->where('asignatura_id', $asignatura_id)
            ->where('docente_dni', $docente_dni)
            ->where('alumno_dni', $alumno_dni)
            ->first();

        if (!$nota) {
            // Manejar la situación en la que no se encuentre la nota
            abort(404, 'Nota no encontrada');
        }

        // Pasar los datos a la vista
        return view('calificaciones.edit', compact('nota', 'tienePermisoEditar'));
    }

    public function update(Request $request, $id)
    {
        $nota = Nota::findOrFail($id);
        $nota->nota_actividades = $request->nota_actividades;
        $nota->nota_practicas = $request->nota_practicas;
        $nota->nota_autonomo = $request->nota_autonomo;
        $nota->examen_final = $request->examen_final;
        $nota->recuperacion = $request->recuperacion;
        $nota->total = $request->total;
        $nota->save();

        return redirect()->route('calificaciones.show1', [$nota->alumno_dni, $nota->docente_dni, $nota->asignatura_id, $nota->cohorte_id])->with('success', 'La nota ha sido actualizada exitosamente.');
    }

    public function show($alumno_dni, $docente_dni, $asignatura_id, $cohorte_id)
    {
        // Obtener la instancia de CalificacionVerificacion
        $calificacionVerificacion = CalificacionVerificacion::where('docente_dni', $docente_dni)
            ->where('asignatura_id', $asignatura_id)
            ->where('cohorte_id', $cohorte_id)
            ->first();

        // Verificar si el usuario tiene permiso de ver las notas
        $tienePermisoVerNotas = $calificacionVerificacion ? $calificacionVerificacion->editar : false;

        // Obtener las notas del alumno en la asignatura y cohorte específicas
        $notas = Nota::where('cohorte_id', $cohorte_id)
                    ->where('asignatura_id', $asignatura_id)
                    ->where('docente_dni', $docente_dni)
                    ->where('alumno_dni', $alumno_dni)
                    ->get();
        
        $cohorte = Cohorte::where('id', $cohorte_id)->first();
        $fechaFinCohorte = $cohorte->periodo_academico->fecha_fin;
        $fechaLimite = $fechaFinCohorte->addWeek();
        
        // Pasar los datos a la vista
        return view('calificaciones.show', compact('notas', 'fechaLimite', 'tienePermisoVerNotas'));
    }
}
