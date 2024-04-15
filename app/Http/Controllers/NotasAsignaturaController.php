<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB;
use App\Models\Asignatura;
use App\Models\Aula;
use App\Models\Paralelo;
use App\Models\Docente;
use App\Models\Cohorte;
use App\Models\Alumno;
use Carbon\Carbon;
class NotasAsignaturaController extends Controller
{
    public function show($docenteDni, $asignaturaId, $cohorteId, $aulaId, $paraleloId)
    {
    
        // Obtén las matrículas de los alumnos en la asignatura, cohorte, aula y paralelo especificados
        $alumnosMatriculados = Alumno::whereHas('matriculas', function ($query) use ($asignaturaId, $cohorteId, $docenteDni) {
            $query->where('asignatura_id', $asignaturaId)
                  ->where('cohorte_id', $cohorteId)
                  ->where('docente_dni', $docenteDni);
        })
        ->with(['matriculas', 'matriculas.asignatura', 'matriculas.cohorte', 'matriculas.docente'])
        ->get();

        $asignatura = Asignatura::find($asignaturaId); 
        $aula = Aula::find($aulaId); 
        $paralelo = Paralelo::find($paraleloId); 
        $docente = Docente::find($docenteDni); 
        $cohorte = Cohorte::find($cohorteId); 

        // Acceder a los datos de periodo_academico en la cohorte
        $periodo_academico = $cohorte->periodo_academico;

        // Acceder a los datos de periodo_academico en la cohorte
        $cohorte = Cohorte::find($cohorteId);
        $fechaActual = Carbon::now()->locale('es')->isoFormat('LL');

        $pdfPath = 'pdfs/' . $docente->apellidop . $docente->nombre1 . $cohorte->nombre . $asignatura->nombre . '_notas.pdf';
        $url = url($pdfPath);
        
        // Reemplazar el esquema "https" con "http"
        $httpUrl = str_replace('https://', 'http://', $url);

        $logoPath = public_path('images/posg.jpg');

        // Generar el código QR con logotipo
        $qrCode = QrCode::format('png')
            ->size(100)
            ->eye('circle') 
            ->gradient(24,115,108, 33,68,59, 'diagonal')
            ->errorCorrection('H') 
            ->merge($logoPath, 0.3, true)
            ->generate($httpUrl);

        // Crear una instancia de Dompdf con las opciones y pasar los datos a la vista PDF
        $pdf = Pdf::loadView('record.notas_asignatura', compact('alumnosMatriculados', 
        'asignatura', 
        'fechaActual',
        'aula', 
        'paralelo', 
        'docente', 
        'periodo_academico', 
        'cohorte',
        'qrCode'    ));

        $pdfDirectory = public_path('pdfs');

        // Verificar si el directorio existe, si no, crearlo
        if (!file_exists($pdfDirectory)) {
            mkdir($pdfDirectory, 0755, true);
        }
        // Guardar el PDF
        $pdf->save(public_path($pdfPath));

        $pdf->setPaper('a4')->setWarnings(false);

        // Mostrar el PDF para visualización o descarga
        return $pdf->stream('notas.pdf');
    }

}
