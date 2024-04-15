<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paralelo;

class ParaleloController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:paralelos,nombre|max:1',
        ]);
        
        $paralelo = new Paralelo;
        $paralelo->nombre = $request->input('nombre');
        $paralelo->save();
    
        return redirect()->route('aulas.index')->with('success', 'Paralelo creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
}
