<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Docente;
use App\Models\Maestria;
use App\Models\Asignatura;
use App\Models\Secretario;
use App\Models\AsignaturaDocente;

class AsignaturaDocenteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create($docente_dni)
    {
        $docente = Docente::findOrFail($docente_dni);
        $asignaturas = Asignatura::all();
        $user = auth()->user();

        if ($user->hasRole('Secretario')) {
            $secretario = Secretario::where('nombre1', $user->name)
                ->where('apellidop', $user->apellido)
                ->where('email', $user->email)
                ->firstOrFail();
            //
            $maestriasIds = $secretario->seccion->maestrias->pluck('id');
            $maestrias = Maestria::whereIn('id', $maestriasIds)
                ->where('status', 'ACTIVO')
                ->get();
            $asignaturas = Asignatura::whereIn('maestria_id', $maestriasIds)->get();
        } else {
            $asignaturas = Asignatura::all();
            $maestrias = Maestria::where('status', 'ACTIVO')->get();
        }

        return view('asignaturas_docentes.create', compact('docente', 'asignaturas', 'maestrias'));
    }

    public function store(Request $request)
    {
        $asignaturas = $request->input('asignaturas');
        $docente_dni = $request->input('docente_dni');

        if(is_array($asignaturas)) {
            foreach ($asignaturas as $asignatura) {
                // Verificar si la asignación ya existe en la base de datos
                $asignacion_existente = AsignaturaDocente::where('docente_dni', $docente_dni)->where('asignatura_id', $asignatura)->first();

                if (!$asignacion_existente) {
                    $asignacion = new AsignaturaDocente();
                    $asignacion->docente_dni = $docente_dni;
                    $asignacion->asignatura_id = $asignatura;
                    $asignacion->save();
                }
            }
        } else {
            // Verificar si la asignación ya existe en la base de datos
            $asignacion_existente = AsignaturaDocente::where('docente_dni', $docente_dni)->where('asignatura_id', $asignaturas)->first();

            if (!$asignacion_existente) {
                $asignacion = new AsignaturaDocente();
                $asignacion->docente_dni = $docente_dni;
                $asignacion->asignatura_id = $asignaturas;
                $asignacion->save();
            }
        }
        return redirect()->route('docentes.index');
    }

    public function destroy($id)
    {
        $asignacion = AsignaturaDocente::findOrFail($id);
        $asignacion->delete();

        return redirect()->route('asignaturas_docentes.index');
    }

}
