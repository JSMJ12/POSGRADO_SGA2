<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maestria;
use App\Models\Asignatura;
use App\Models\Docente;
use App\Models\Cohorte;
use App\Models\CohorteDocente;

class CohorteDocenteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function create($docente_dni, $asignatura_id = null)
    {
        $docente = Docente::where('dni', $docente_dni)->firstOrFail();
        $asignaturas = $docente->asignaturas;
        
        if ($asignatura_id) {
            $asignatura = Asignatura::findOrFail($asignatura_id);
            $maestria = Maestria::findOrFail($asignatura->maestria_id);
            $cohortes = $maestria->cohorte;

            $maestriaCohortes = [
                [
                    'asignatura' => $asignatura,
                    'maestria' => $maestria,
                    'cohortes' => $cohortes
                ]
            ];
        } else {
            $maestriaCohortes = [];

            foreach ($asignaturas as $asignatura) {
                $maestria = Maestria::findOrFail($asignatura->maestria_id);
                $cohortes = $maestria->cohorte;
                $maestriaCohortes[] = [
                    'asignatura' => $asignatura,
                    'maestria' => $maestria,
                    'cohortes' => $cohortes
                ];
            }
        }

        return view('cohortes_docentes.create', compact('docente', 'asignaturas', 'maestriaCohortes', 'asignatura_id'));
    }
    public function store(Request $request)
    {
        $cohorteIds = $request->input('cohorte_id', []);
        $docenteDni = $request->input('docente_dni');      
        $asignaturaId = $request->input('asignatura_id');

        foreach ($cohorteIds as $cohorteId) {
            CohorteDocente::updateOrCreate(
                [
                    'cohort_id' => $cohorteId,
                    'docente_dni' => $docenteDni,
                    'asignatura_id' => $asignaturaId,
                ],
            );
        }
        foreach ($cohorteIds as $cohorteId) {
            // Verificar si ya hay notas para esta combinación
            $notasExistentes = Nota::where([
                'cohorte_id' => $cohorteId,
                'docente_dni' => $docenteDni,
                'asignatura_id' => $asignaturaId,
            ])->exists();
        
            // Crear o actualizar la calificación de verificación
            CalificacionVerificacion::updateOrCreate(
                [
                    'cohorte_id' => $cohorteId,
                    'docente_dni' => $docenteDni,
                    'asignatura_id' => $asignaturaId,
                    'calificado' => $notaExistente,
                    'editar' => !$notaExistente,
                ],

            );
        }

        return redirect()->route('docentes.index');
    }
}
