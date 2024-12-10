<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::all(); // Obtener todos los usuarios
        return view('usuarios.index', compact('usuarios'));
    }

    // Método para editar un usuario
    public function edit($id)
    {
    $usuario = User::findOrFail($id);

    // Verifica si el usuario autenticado es el mismo que el usuario que se está editando
    if (auth()->user()->id == $usuario->id) {
        // No permitir cambiar el rol si es el mismo usuario
        return view('usuarios.edit', compact('usuario'))->with('disableRole', true);
    }

    return view('usuarios.edit', compact('usuario'));
    }

    

    // Método para actualizar el usuario en la base de datos
    public function update(Request $request, $id)
    {
    $usuario = User::findOrFail($id);
    // Validar los datos
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email:rfc,dns|max:255|unique:users,email,' . $usuario->id,
        'current_password' => 'nullable|required_with:new_password',
        'new_password' => 'nullable|min:8|confirmed',
        'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    // Verificar la contraseña actual si se proporciona una nueva
    if ($request->filled('current_password') && $request->filled('new_password')) {
        if (!Hash::check($request->current_password, $usuario->password)) {
            throw ValidationException::withMessages(['current_password' => 'La contraseña actual es incorrecta.']);
        }
        // Cambiar la contraseña
        $usuario->password = Hash::make($request->new_password);
    }
    // Actualizar otros datos del usuario
    $usuario->name = $request->name;
    $usuario->email = $request->email;
    // Si el usuario autenticado es administrador y no se está editando a sí mismo, actualizar el rol
    if (Auth::user()->role == 'admin' && Auth::user()->id != $usuario->id) {
        $usuario->role = $request->role;
    }
//--------------------------------------------------------------------------------------------------------------
  // Procesar la foto de perfil si se ha subido una nueva
 if ($request->hasFile('profile_picture')) {
    $imageName = time() . '.' . $request->profile_picture->getClientOriginalExtension();
    $path = $request->profile_picture->move(public_path('images'), $imageName);

    if ($path) {
        $usuario->profile_picture = '/images/' . $imageName; // Guarda la ruta en la base de datos
    }
}
//--------------------------------------------------------------------------------------------------------------
if (!$usuario->profile_picture && $request->hasFile('profile_picture')) {
    return back()->with('error', 'No se ha podido cargar la imagen.');
}

$usuario->save();
return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
   }


    

    // Método para eliminar un usuario
    public function destroy($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente');
    }


    // Método para mostrar el formulario de creación de usuarios
    public function create()
    {
        return view('usuarios.create');
    }


    // Método para almacenar un nuevo usuario en la base de datos
    public function store(Request $request)
    {
    // Validación de datos
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email:rfc,dns|max:255|unique:users|regex:/^[\w\.-]+@[\w\.-]+\.\w{2,}$/',
        'password' => 'required|string|min:8|confirmed',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación para la imagen
    ]);
    // Asignar rol dependiendo de quién esté realizando la acción
    if (auth()->user()->role == 'admin') {
        $role = $request->role;
    } else {
        $role = 'user';
    }
  // Asignar una imagen por defecto si no se sube ninguna
    $profilePicturePath = 'images/default-profile.png'; // Ruta relativa de la imagen por defecto
    if ($request->hasFile('profile_picture')) {
        $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
    }
    // Crear el nuevo usuario
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        'role' => $role,
        'profile_picture' => $profilePicturePath, // Guardar la ruta de la imagen
    ]);
    // Redirigir a la lista de usuarios o a otra vista con mensaje de éxito
    return redirect()->route('usuarios.index')->with('success', 'Usuario añadido con éxito.');
    }

}
