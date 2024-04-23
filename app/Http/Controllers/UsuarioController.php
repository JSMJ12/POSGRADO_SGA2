<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;


class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $usuarios = User::all();
        return view('usuarios.index', compact('usuarios', 'perPage'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('usuarios.create', compact('roles'));
    }
    
    public function store(Request $request)
    {
        $usuario = new User();
    
        $usuario->name = $request->input('usu_nombre');
        $usuario->apellido = $request->input('usu_apellido');
        $usuario->sexo = $request->input('usu_sexo');
        $usuario->email = $request->input('email');
        $usuario->password = bcrypt($request->input('usu_contrasena'));
        $usuario->status = $request->input('usu_estatus', 'ACTIVO');
        $request->validate([
            'usu_foto' => 'nullable|image|max:2048', // Máximo tamaño 2MB
        ]);
        
        $primeraLetra = substr($usuario->name, 0, 1);
        
        // Almacenar la imagen
        if ($request->hasFile('usu_foto')) {
            $imagePath = $request->file('usu_foto')->store('public/imagenes_usuarios');
            $usuario->image = asset(str_replace('public/', 'storage/', $imagePath));
        } else {
            $usuario->image = 'https://ui-avatars.com/api/?name=' . urlencode($primeraLetra);
        }

        $usuario->save();
        $usuario->roles()->sync($request->roles);
    
        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }
    
    public function edit(User $usuario)
    {
        $roles = Role::all();
        return view('usuarios.edit', compact('usuario', 'roles'));
    }
    
    public function update(Request $request, User $usuario)
    {
        
        $usuario->name = $request->input('name'); 
        $usuario->apellido = $request->input('apellido');

        $usuario->save();
        $usuario->roles()->sync($request->roles);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado exitosamente.');

    }
    
    public function checkUserOneStatus()
    {
        $user1 = User::find(1);

        if ($user1 && $user1->status === 'INACTIVO') {
            User::where('id', '<>', 1)->update(['status' => 'INACTIVO']);
            return redirect()->route('usuarios.index')->with('success', 'Todos los usuarios han sido deshabilitados.');
        } else {
            User::where('id', '<>', 1)->update(['status' => 'INACTIVO']);
            return redirect()->route('usuarios.index')->with('success', 'Todos los usuarios han sido deshabilitados.');
        }
    }

    public function disable(User $usuario)
    {
        $this->checkUserOneStatus();
        if ($usuario->id !== 1) {
            $usuario->status = 'INACTIVO';
            $usuario->save();

            return redirect()->route('usuarios.index')->with('success', 'Usuario deshabilitado exitosamente.');
        } else {
            return redirect()->route('usuarios.index')->with('error', 'No se puede deshabilitar al usuario con ID 1.');
        }
    }
        
    public function enable(User $usuario)
    {
        $usuario->status = 'ACTIVO';
        $usuario->save();
    
        return redirect()->route('usuarios.index')->with('success', 'Usuario habilitado exitosamente.');
    }
    

}
