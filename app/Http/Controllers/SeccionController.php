<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Maestria;
use App\Models\Seccion;
class SeccionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $secciones = Seccion::with('maestrias')->get();
        return view('secciones.index', compact('secciones', 'perPage'));
    }

    public function create()
    {
        $maestrias = Maestria::whereDoesntHave('secciones')->get();
        return view('secciones.create', compact('maestrias'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255|unique:secciones,nombre',
            'maestrias' => 'required|array|min:1',
            'maestrias.*' => 'exists:maestrias,id',
        ]);

        $seccion = new Seccion();
        $seccion->nombre = $validatedData['nombre'];
        $seccion->save();

        $maestrias = collect($validatedData['maestrias'])->unique();
        $seccion->maestrias()->attach($maestrias);

        return redirect()->route('secciones.index')->with('success', 'Sección creada exitosamente');
    }

    public function edit(Seccion $seccion)
    {
        return view('secciones.edit', compact('seccion'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255|unique:secciones,nombre,' . $id,
            'maestrias' => 'required|array|min:1',
            'maestrias.*' => 'exists:maestrias,id',
        ]);

        // Buscar la sección que se desea actualizar por su ID
        $seccion = Seccion::findOrFail($id);

        // Actualizar el nombre de la sección
        $seccion->nombre = $validatedData['nombre'];
        $seccion->save();

        // Actualizar las maestrías asociadas a la sección
        $maestrias = collect($validatedData['maestrias'])->unique();
        $seccion->maestrias()->sync($maestrias);

        return redirect()->route('secretarios.index')->with('success', 'Sección actualizada exitosamente');
    }

    public function destroy($id)
    {
        // Buscar la sección por su ID
        $seccion = Seccion::findOrFail($id);

        // Desvincular las maestrías de la sección antes de eliminarla
        $seccion->maestrias()->detach();

        // Eliminar la sección
        $seccion->delete();

        return redirect()->route('secciones.index')->with('success', 'Sección eliminada exitosamente');
    }
}
