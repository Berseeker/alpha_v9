<?php

namespace App\Http\Controllers\WEB\Dashboard\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['link' => "/home", 'name' => "Dashboard"], ['link' => "/dashboard/users", 'name' => "Usuarios"], ['name' => "Crear Usuario"]
        ];

        return view('dashboard.users.index',[
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function store( Request $request ){
        $rules = [
            'name' =>    'required|string',
            'email'=>    'required|email',
            'password'=> 'required'
        ];

        $messages = [
            'name.required' => 'Es necesario llenar este campo',
            'name.string' => 'Nombre no valido',
            'email.required' => 'Es necesario llenar este campo',
            'email.email' => 'Email no valido',
            'password.required' => 'Es necesario llenar este campo'
        ];
        
        $this->validate($request, $rules, $messages);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();
        $user->assignRole('Usuario');
        return back()->with('success',"Usuario creado correctamente");
        
    }
    
    public function delete( $id ){
        
        $user =  User::find($id);
        if( $user == null && $user->hasRole('Empleado')){
            return back()->with('warning',"Usuario no encontrado");
        }
        
        $user->delete();
        return back()->with('success',"Usuario eliminado correctamente");
        
    }

    public function update( Request $request, $id ){
        $rules = [
            'name' =>    'required|string',
            'email'=>    'required|email',
        ];

        $messages = [
            'name.required' => 'Es necesario llenar este campo',
            'name.string' => 'Nombre no valido',
            'email.required' => 'Es necesario llenar este campo',
            'email.email' => 'Email no valido',
        ];
        
        $this->validate($request, $rules, $messages);
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();
        return back()->with('success',"Usuario modificado correctamente");
        
    }
}
