<?php

namespace App\Http\Controllers\API\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    public function index(){
        return view('dashboard.users.index');
    }

    public function empleados()
    {
        $users = User::role(['Admin', 'Supervisor', 'Empleado'])->get();
        return $users->toJson();
    }
}
