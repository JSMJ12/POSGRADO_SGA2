<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aula;
use App\Models\Paralelo;
class AulaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $paralelos = Paralelo::all();
        $aulas = Aula::with('paralelo')->get();
        return view('aulas.index', compact('aulas', 'paralelos', 'perPage'));
    }


    public function store(Request $request)
    {
        $aula = new Aula;
        $aula->nombre = $request->nombre;
        $aula->piso = $request->piso;
        $aula->codigo = $request->codigo;
        $aula->paralelos_id = $request->paralelos_id;
        $aula->save();
        return redirect()->route('aulas.index')->with('success', 'Aula creada correctamente.');
    }



    public function update(Request $request, $id)
    {
        $aula = Aula::find($id);
        $aula->nombre = $request->nombre;
        $aula->piso = $request->piso;
        $aula->codigo = $request->codigo;
        $aula->paralelos_id = $request->paralelos_id;
        $aula->save();
        return redirect()->route('aulas.index')->with('success', 'Aula actualizada correctamente.');
    }

    public function destroy($id)
    {
        $aula = Aula::find($id);
        $aula->delete();
        return redirect()->route('aulas.index')->with('success', 'Aula eliminada correctamente.');
    }
}
