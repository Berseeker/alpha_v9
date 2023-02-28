<?php

namespace App\Http\Controllers\WEB\Dashboard\Role;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['link' => "/home", 'name' => "Dashboard"], ['name' => "Usuarios"]
        ];
        $users =  User::all();
        $roles =  Role::all();
        return view("dashboard.users.show-users",[
            'users' => $users,
            'roles' => $roles,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function update( Request $request, $id ){
        $rules = [
            'name' =>    'required|string',
            'email'=>    'required|email',
            'roles' =>    'required|numeric'
        ];

        $messages = [
            'name.required' => 'Es necesario llenar este campo',
            'name.string' => 'Nombre no valido',
            'email.required' => 'Es necesario llenar este campo',
            'email.email' => 'Email no valido',
            'roles.required' => 'Es necesario llenar este campo',
            'roles.numeric' => 'Rol no valido'
        ];

        $this->validate($request, $rules, $messages);
        
       $user = User::find($id);
       $user->name = $request->name;
       $user->email = $request->email;
       $user->phone = $request->phone;

        //Se verifica que el usuario cuente con un rol, de lo contrario no se hace nada
        if ($user->hasRole(['Admin', 'Supervisor', 'Empleado', 'Usuario'])) {
            //Caso de Uso: El usuario ya cuenta con un rol asigando previamente
            //obtienes el nombre del rol que vas a borrar
            $rol = $user->getRoleNames()[0];
            //borras el rol viejo
            foreach($user->getAllPermissions() as $permission){
                    $user->revokePermissionTo($permission->name);
            }

            $user->removeRole($rol);
        }
       
       //asignamiento de nuevo rol, trayendo el rol desde la vista
       $new_rol = Role::find($request->roles);
       $user->assignRole($new_rol->name);
       $user->syncRoles($new_rol);
       switch($new_rol->name){
        case 'Admin':
            $user->givePermissionTo('all');

        break;
        case 'Supervisor':
            $user->givePermissionTo('create', 'update', 'delete', 'read');

        break;
        case 'Empleado':
            $user->givePermissionTo('create', 'update', 'read');

        break;
        case 'Usuario':
            $user->givePermissionTo('read');

        break;
       }
       //guardas el nuevo rol en la base de datos
       $user->save();

       return back()->with('success',"Usuario actualizado correctamente");
       

    }

}
