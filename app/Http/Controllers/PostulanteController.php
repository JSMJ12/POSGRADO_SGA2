<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Postulante;
use App\Models\Maestria;
use App\Models\Secretario;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NuevoUsuarioNotification;
use Illuminate\Validation\Rule;

class PostulanteController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $user = auth()->user();

        if ($user->hasRole('Administrador')) {
            $postulantes = Postulante::all();
        } else {
            $secretario = Secretario::where('nombre1', $user->name)
                ->where('apellidop', $user->apellido)
                ->where('email', $user->email)
                ->firstOrFail();
            $maestriasIds = $secretario->seccion->maestrias->pluck('id');
            $postulantes = Postulante::whereIn('maestria_postular', $maestriasIds)->get();
        }
        $postulantes = Postulante::all();
        return view('postulantes.index', compact('postulantes', 'perPage'));
    }

    public function create()
    {
        $maestrias = Maestria::where('status', 'ACTIVO')->get();
        $provincias = ['Azuay', 'Bolívar', 'Cañar', 'Carchi', 'Chimborazo', 'Cotopaxi', 'El Oro', 'Esmeraldas', 'Galápagos', 'Guayas', 'Imbabura', 'Loja', 'Los Ríos', 'Manabí', 'Morona Santiago', 'Napo', 'Orellana', 'Pastaza', 'Pichincha', 'Santa Elena', 'Santo Domingo de los Tsáchilas', 'Sucumbíos', 'Tungurahua', 'Zamora Chinchipe'];
        $tipo_colegio = [
            'FISCAL',
            'FISCOMISIONAL',
            'PARTICULAR',
            'MUNICIPAL',
            'EXTRANJERO',
            'NO REGISTRA'
        ];
        $ingreso_hogar = [
            'RANGO 1 - HASTA 1 SBU',
            'RANGO 2 - MÁS DE 1 A MENOS DE 2 SBU',
            'RANGO 3 - MÁS DE 2 A MENOS DE 3 SBU',
            'RANGO 4 - MÁS DE 3 A MENOS DE 4 SBU',
            'RANGO 5 - MÁS DE 4 A MENOS DE 5 SBU',
            'RANGO 6 - MÁS DE 5 A MENOS DE 6 SBU',
            'RANGO 7 - MÁS DE 6 A MENOS DE 7 SBU',
            'RANGO 8 - MÁS DE 7 A MENOS DE 8 SBU',
            'RANGO 9 - MÁS DE 8 A MENOS DE 9 SBU',
            'RANGO 10-DE 9 EN ADELANTE',
            'NO REGISTRA'
        ];
        $formacion_padre = [
            'NINGUNO',
            'CENTRO DE ALFABETIZACIÓN',
            'JARDIN INFANTES',
            'EDUCACIÓN BÁSICA',
            'EDUCACIÓN MEDIA',
            'SUPERIOR NO UNIVERSITARIA COMPLETA',
            'SUPERIOR NO UNIVERSITARIA INCOMPLETA',
            'SUPERIOR UNIVERSITARIA COMPLETA',
            'SUPERIOR UNIVERSITARIA INCOMPLETA',
            'DIPLOMADO',
            'ESPECIALIDAD',
            'POSGRADO MAESTRÍA',
            'POSGRADO ESPECIALIDAD ÁREA SALUD',
            'POSGRADO PHD',
            'NO SABE',
            'NO REGISTRA'
        ];
        $origen_recursos = [
            'RECURSOS PROPIOS',
            'PADRES TUTORES',
            'PAREJA SENTIMENTAL',
            'HERMANOS',
            'OTROS MIEMBROS DEL HOGAR',
            'OTROS FAMILIARES',
            'BECA ESTUDIO',
            'CRÉDITO EDUCATIVO',
            'NO REGISTRA'
        ];
        
        return view('postulantes.create', compact('maestrias','provincias', 'tipo_colegio','ingreso_hogar','formacion_padre','origen_recursos'));
    }
    public function store(Request $request)
    {
        Storage::makeDirectory('public/postulantes/imagen');
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('postulantes/imagen', 'public');
        }
        $request->validate([
            'dni' => 'required|unique:postulantes',
            'correo_electronico' => 'required|email|unique:postulantes',
        ]);
        
        Postulante::create([
            'dni' => $request->input('dni'),
            'apellidop' => $request->input('apellidop'),
            'apellidom' => $request->input('apellidom'),
            'nombre1' => $request->input('nombre1'),
            'nombre2' => $request->input('nombre2'),
            'correo_electronico' => $request->input('correo_electronico'),
            'celular' => $request->input('celular'),
            'titulo_profesional' => $request->input('titulo_profesional'),
            'universidad_titulo' => $request->input('universidad_titulo'),
            'sexo' => $request->input('sexo'),
            'fecha_nacimiento' => $request->input('fecha_nacimiento'),
            'nacionalidad' => $request->input('nacionalidad'),
            'discapacidad' => $request->input('discapacidad'),
            'porcentaje_discapacidad' => $request->input('porcentaje_discapacidad'),
            'codigo_conadis' => $request->input('codigo_conadis'),
            'provincia' => $request->input('provincia'),
            'etnia' => $request->input('etnia'),
            'nacionalidad_indigena' => $request->input('nacionalidad_indigena'),
            'canton' => $request->input('canton'),
            'direccion' => $request->input('direccion'),
            'tipo_colegio' => $request->input('tipo_colegio'),
            'cantidad_miembros_hogar' => $request->input('cantidad_miembros_hogar'),
            'ingreso_total_hogar' => $request->input('ingreso_total_hogar'),
            'nivel_formacion_padre' => $request->input('nivel_formacion_padre'),
            'nivel_formacion_madre' => $request->input('nivel_formacion_madre'),
            'origen_recursos_estudios' => $request->input('origen_recursos_estudios'),
            'maestria_id' => $request->input('maestria_id'),
            'imagen' => $imagenPath ?? null,
        ]);
        $usuario = new User;
        $usuario->name = $request->input('nombre1');
        $usuario->apellido = $request->input('apellidop');
        $sexo = $request->input('sexo');

        if ($sexo == 'HOMBRE') {
            $usuario->sexo = 'M';
        } elseif ($sexo == 'MUJER') {
            $usuario->sexo = 'F';
        } 
        $usuario->password = bcrypt($request->input('dni'));
        $usuario->status = $request->input('estatus', 'ACTIVO');
        $usuario->email = $request->input('correo_electronico');
        $usuario->image = $imagenPath ?? null;
        $postulanteRole = Role::findById(5);
        $usuario->assignRole($postulanteRole);
        $usuario->save();
        Notification::route('mail', $usuario->email)
        ->notify(new NuevoUsuarioNotification($usuario, $request->input('dni'), $usuario->name));
        return redirect()->route('dashboard_postulante')->with('success', 'Postulación realizada exitosamente.');
    }

    public function show($dni)
    {
        $postulante = Postulante::findOrFail($dni);
        return view('postulantes.show', compact('postulante'));
    }
    public function destroy($dni)
    {
        $postulante = Postulante::findOrFail($dni);
        $postulante->delete();

        return redirect()->route('postulantes.index')->with('success', 'Postulante eliminado exitosamente.');
    }
}
