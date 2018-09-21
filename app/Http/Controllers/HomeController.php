<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /**
         *  No primeiro acesso, o sistema força o registro do usuário Administrador. Para isso,
         *      ele faz uma contagem na tabela "usuario", representada pela Model User. Caso
         *      não haja usuarios cadastrados, o sistema redirieciona para a tela de registro
         *      de usuários (RegisterController.php)
         *
         */
        $this->middleware(function($request, $next){
            if (User::count() == 0){
                return redirect('/register');
            }
            return $next($request);
        });

        /*
        $this->middleware('auth');
        */
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
}
