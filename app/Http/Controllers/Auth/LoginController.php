<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
//use App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    
    public function loginView() {
        return view('auth.login');
    }

    public function login(Request $request){


        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'El campo de correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico no tiene un formato válido.',
            'password.required' => 'El campo de contraseña es obligatorio.',
        ]);

        $credentials=[
            "email"=> $request->email,
            "password"=> $request->password,
        ];

   
       // if (!$request->filled(['email', 'password'])) {
       //     return redirect(route('login'))->withErrors(['error' => 'Debe completar todos los campos.']);
    //} 

       $remember= ($request->has('remember')? true : false);
       if(Auth::attempt($credentials, $remember)){
            $request->session()->regenerate();
            return redirect()->intended(route('formulario'));
        }else{
            return redirect(route('login'));
        }

    }  
}

 /**use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
    
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    } */