<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Docente;
use App\Models\Alumno;
use App\Models\CohorteDocente;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AlumnosExport;
use App\Models\Nota;
use App\Models\CalificacionVerificacion;
class DashboardDocenteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $user = auth()->user();
        $docente = Docente::where('email', $user->email)->firstOrFail();
        $asignaturas = $docente->asignaturas;
        
        $data = $asignaturas->map(function ($asignatura) use ($docente, &$notasExisten) { 
            return [
                'nombre' => $asignatura->nombre,
                'cohortes' => $asignatura->cohortes->sortBy('periodo_academico.fecha_fin')->map(function ($cohorte) use ($docente, $asignatura, &$notasExisten, &$calificarUrlParamsArray) {
                    $fechaFinCohorte = $cohorte->periodo_academico->fecha_fin;
                    $fechaLimite = $fechaFinCohorte->addWeek();
        
                    $notasExisten[$cohorte->id] = Nota::where([
                        'docente_dni' => $docente->dni,
                        'asignatura_id' => $asignatura->id,
                        'cohorte_id' => $cohorte->id,
                    ])->exists();
                    
                    // Obtener la instancia de CalificacionVerificacion
                    $calificacionVerificacion = CalificacionVerificacion::where([
                        'docente_dni' => $docente->dni,
                        'asignatura_id' => $asignatura->id,
                        'cohorte_id' => $cohorte->id,
                    ])->first();
        
                    // Obtener el valor de la propiedad 'editar' o establecerlo en false si no hay instancia
                    $editar = $calificacionVerificacion ? $calificacionVerificacion->editar : null;
                    
                    $calificarUrlParams = [
                        $docente->dni,
                        $asignatura->id,
                        $cohorte->id,
                        $cohorte->aula->id,
                        $cohorte->aula->paralelo->id,
                        $notasExisten[$cohorte->id] 
                    ];
                    $calificarUrlParamsArray[] = $calificarUrlParams;
        
                    return [
                        'nombre' => $cohorte->nombre,
                        'aula' => $cohorte->aula->nombre,
                        'paralelo' => $cohorte->aula->paralelo->nombre,
                        'fechaLimite' => $fechaLimite,
                        'docenteId' => $docente->dni,
                        'asignaturaId' => $asignatura->id,
                        'cohorteId' => $cohorte->id,
                        'pdfNotasUrl' => $notasExisten[$cohorte->id] ? route('pdf.notas.asignatura', [
                            'docenteId' => $docente->dni,
                            'asignaturaId' => $asignatura->id,
                            'cohorteId' => $cohorte->id,
                            'aulaId' => $cohorte->aula->id,
                            'paraleloId' => $cohorte->aula->paralelo->id,
                        ]) : null,
                        'excelUrl' => route('exportar.excel', [
                            'docenteId' => $docente->dni,
                            'asignaturaId' => $asignatura->id,
                            'cohorteId' => $cohorte->id,
                            'aulaId' => $cohorte->aula->id,
                            'paraleloId' => $cohorte->aula->paralelo->id,
                        ]),
                        'calificarUrl' => $editar ? route('calificaciones.create1', end($calificarUrlParamsArray)) : null,
                        'alumnos' => $cohorte->matriculas->unique(['alumno_dni'])->map(function ($matricula) use ($docente, $asignatura, $cohorte){
                            return [
                                'imagen' => asset($matricula->alumno->image),
                                'nombreCompleto' => $matricula->alumno->apellidop . ' ' . $matricula->alumno->apellidom . ' ' . $matricula->alumno->nombre1 . ' ' . $matricula->alumno->nombre2,
                                'verNotasUrl' => route('calificaciones.show1',  [$matricula->alumno->dni, $docente->dni, $asignatura->id, $cohorte->id]),
                            ];
                        }),
                    ];
                })->values(), 
            ];
        });
        
        return view('dashboard.docente', compact('docente', 'asignaturas', 'perPage', 'data', 'notasExisten'));
    }

    public function exportarExcel($docenteId, $asignaturaId, $cohorteId, $aulaId, $paraleloId)
    {
        $alumnosMatriculados = Alumno::whereHas('matriculas', function ($query) use ($asignaturaId, $cohorteId, $docenteId) {
            $query->where('asignatura_id', $asignaturaId)
                  ->where('cohorte_id', $cohorteId)
                  ->where('docente_dni', $docenteId);
        })
        ->with(['matriculas', 'matriculas.asignatura', 'matriculas.cohorte', 'matriculas.docente'])
        ->get();

        $cohorte = $alumnosMatriculados->first()->matriculas->first()->cohorte;
        $nombreCohorte = $cohorte ? $cohorte->nombre : 'sin_cohorte';
        $paralelo = $cohorte->aula->paralelo->nombre;
        $aula = $cohorte->aula->nombre;
        $asignatura = $alumnosMatriculados->first()->matriculas->first()->asignatura->nombre;
    
        return Excel::download(new AlumnosExport($alumnosMatriculados), "alumnos_{$nombreCohorte}_{$asignatura}_{$aula}_{$paralelo}.xlsx");
    
    }

}
