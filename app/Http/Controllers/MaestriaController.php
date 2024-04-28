<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maestria;
use App\Models\Docente;

class MaestriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $maestrias = Maestria::with('asignaturas', )->get();
        $docentes = Docente::all();

        return view('maestrias.index', compact('maestrias', 'docentes', 'perPage'));
    }

    public function create()
    {
        return view('maestrias.create');
    }

    public function store(Request $request)
    {   
        $maestria = new Maestria;
        $maestria->nombre = $request->input('nombre');
        $maestria->coordinador = $request->input('coordinador');
        $maestria->matricula = $request->input('matricula');
        $maestria->arancel = $request->input('arancel');
        $maestria->inscripcion = $request->input('inscripcion');
        $maestria->save();

        return redirect()->route('maestrias.index')->with('success', 'Maestría creada exitosamente.');
    }

    
    public function edit(Maestria $maestria)
    {
        return view('maestrias.edit', compact('maestria'));
    }

    public function update(Request $request, Maestria $maestria)
    {
        $maestria->nombre = $request->input('nombre');
        $maestria->coordinador = $request->input('coordinador');
        $maestria->matricula = $request->input('matricula');
        $maestria->arancel = $request->input('arancel');
        $maestria->inscripcion = $request->input('inscripcion');
        $maestria->save();

        return redirect()->route('maestrias.index')->with('success', 'Maestria actualizada exitosamente.');
    }
    public function enable(Maestria $maestria)
    {
        $maestria->status = 'ACTIVO';
        $maestria->save();
    
        return redirect()->route('maestrias.index')->with('success', 'Maestria habilitada exitosamente.');
    }
    public function disable(Maestria $maestria)
    {
        $maestria->status = 'INACTIVO';
        $maestria->save();
    
        return redirect()->route('maestrias.index')->with('success', 'Maestria deshabilitada exitosamente.');
    }
}
