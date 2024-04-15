<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeriodoAcademico;
use Carbon\Carbon;

class PeriodoAcademicoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $periodos_academicos = PeriodoAcademico::all();
        foreach ($periodos_academicos as $periodo_academico) {
            $periodo_academico->actualizarEstado();
        }
        return view('periodos_academicos.index', compact('periodos_academicos', 'perPage'));
    }

    public function create()
    {
        return view('periodos_academicos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        PeriodoAcademico::create([
            'nombre' => $request->input('nombre'),
            'fecha_inicio' => $request->input('fecha_inicio'),
            'fecha_fin' => $request->input('fecha_fin'),
        ]);
        return redirect()->route('periodos_academicos.index')->with('success', 'El periodo académico ha sido creado exitosamente.');
    }

    public function edit($id)
    {
        $periodo_academico = PeriodoAcademico::findOrFail($id);
        return view('periodos_academicos.edit', compact('periodo_academico'));
    }

    public function update(Request $request, PeriodoAcademico $periodo_academico)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $periodo_academico->update([
            'nombre' => $request->input('nombre'),
            'fecha_inicio' => $request->input('fecha_inicio'),
            'fecha_fin' => $request->input('fecha_fin'),
        ]);

        return redirect()->route('periodos_academicos.index')->with('success', 'El periodo académico ha sido actualizado exitosamente.');
    }

    public function destroy(PeriodoAcademico $periodo_academico)
    {
        $periodo_academico->delete();

        return redirect()->route('periodos_academicos.index')->with('success', 'El periodo académico ha sido eliminado exitosamente.');
    }
    
}
