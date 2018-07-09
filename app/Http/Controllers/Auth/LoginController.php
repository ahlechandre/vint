<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Mostra o formulário de login.
     * 
     * @return \Illuminate\Http\Response
     */
    public function login() 
    {
        return view('system::pages.auth.login');
    }

    /**
     * Tenta autenticar o usuário.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request) 
    {
        $credentials = [
            'identification_number' => $request->get('identification_number'),
            'password' => $request->get('password'),
        ];
        $remember = $request->get('remember_me') ? true : false;

        // Tenta autenticar o usuário com as credenciais fornecidas.
        if (Auth::attempt($credentials, $remember)) {

            return redirect($this->redirectTo);
        }

        return redirect('/login')->withErrors([
            'auth' => 'E-mail ou senha inválidos'
        ]);
    }

    /**
     * 
     * @return Response
     */
    public function logout() 
    {
        Auth::logout();

        return redirect('/login')
            ->with('status', 'Faça login para continuar');
    }
}
