<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Perfil;
use App\Pessoa;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      //  $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nome' => 'required|max:255',
            'login' => 'required|unique:users',
            'email' => 'required|email|max:255|unique:pessoa',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
		$pessoa = new Pessoa();
        $pessoa->nome = $data['nome'];
        $pessoa->email = $data['email'];
        $pessoa->save();
		
		$user = new User();
        $user->login = $data['login'];
        $user->password = bcrypt($data['password']);

        // Associando o usuário ao perfil 1 - Administrador
        $user->perfil()->associate(Perfil::find(1));
        $user->pessoa()->associate($pessoa);

        $user->save();

        return $user;



//        return User::create([
//            'nome' => $data['nome'],
//            'cpf' => $data['cpf'],
//            'login' => $data['login'],
//            'email' => $data['email'],
//            'password' => bcrypt($data['password']),
//            'perfil_id' => 1,   // Administrador
//        ]);
    }
}
