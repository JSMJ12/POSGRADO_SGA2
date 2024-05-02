<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Postulante;
use App\Models\Maestria;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Postulacion2;

class DashboardPostulanteController extends Controller
{
    
    public function index()
    {
        $user = auth()->user();
        $postulante = Postulante::where('nombre1', $user->name)
        ->where('apellidop', $user->apellido)
        ->where('correo_electronico', $user->email)
        ->with(['maestria.cohorte' => function ($query) {
            $query->latest(); 
        }])
        ->firstOrFail();
        return view('dashboard.postulante', compact('postulante'));
    }
    public function store(Request $request)
    {
        $user = auth()->user();
        $postulante = Postulante::where('nombre1', $user->name)
        ->where('apellidop', $user->apellido)
        ->where('correo_electronico', $user->email)
        ->firstOrFail();
        Storage::makeDirectory('public/postulantes/pdf');

        // Subir archivos PDF
        $pdfCedulaPath = $request->file('pdf_cedula')->store('postulantes/pdf', 'public');
        $pdfPapelVotacionPath = $request->file('pdf_papelvotacion')->store('postulantes/pdf', 'public');
        $pdfTituloUniversidadPath = $request->file('pdf_titulouniversidad')->store('postulantes/pdf', 'public');
        $pdfhojavidaPath = $request->file('pdf_hojavida')->store('postulantes/pdf', 'public');
        $pdfConadisPath = $request->hasFile('pdf_conadis') ? $request->file('pdf_conadis')->store('postulantes/pdf', 'public') : null;
        // Crear el postulante con los datos y rutas de los archivos
        $postulante->update([
            'pdf_cedula' => $pdfCedulaPath,
            'pdf_papelvotacion' => $pdfPapelVotacionPath,
            'pdf_titulouniversidad' => $pdfTituloUniversidadPath,
            'pdf_conadis' => $pdfConadisPath ?? null,
            'pdf_hojavida' => $pdfhojavidaPath,
        ]);
        Notification::route('mail', $postulante->correo_electronico)
        ->notify(new Postulacion2($postulante));

        return redirect()->route('welcome')->with('success', 'Postulación realizada exitosamente.');

    }
}
