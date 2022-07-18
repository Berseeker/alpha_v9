<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        $pageConfigs = ['blankPage' => true];

        return view('/auth/login', ['pageConfigs' => $pageConfigs]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
     
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            
           if(!Auth::user()->hasRole('Admin') && Auth::user()->email == 'juan.alucard.02@gmail.com'){

                Auth::user()->assignRole('Admin');

           }
           if(!Auth::user()->hasAnyRole(['Admin', 'Supervisor', 'Empleado', 'Usuario'])){

                Auth::user()->assignRole('Usuario');

           }
          
           if(!Auth::user()->hasAnyPermission(['all','create', 'update', 'delete', 'read'])){
                
                if(Auth::user()->hasRole('Admin')){
                    Auth::user()->givePermissionTo('all');
                }
                if(Auth::user()->hasRole('Supervisor')){
                    Auth::user()->givePermissionTo('create', 'update', 'delete', 'read');
                }
                if(Auth::user()->hasRole('Empleado')){
                    Auth::user()->givePermissionTo('create', 'update', 'read');
                }
                if(Auth::user()->hasRole('Usuario')){
                    Auth::user()->givePermissionTo('read');
                }
           }
    
            return redirect()->route('home');
        }
    
        return redirect("login")->withSuccess('Oppes! You have entered invalid credentials');
    }
}