<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\User;
use App\Perfil;
use App\Pessoa;

class UsuarioController extends Controller
{
    public function __construct()
    {
        /**
         *  O sistema verifica primeiramente se o usuário está logado no sistema. Caso não esteja, 
         *      ele é direcionado para a tela de login. Caso o usuário esteja logado, o sistema
         *      verifica se ele tem perfil de administrador. Caso não tenha, ele é redirecionado
         *      para a tela inicial do sistema
         *
         */
        $this->middleware(function($request, $next){
            if (Auth::check() == false){
                return redirect('/login');
            }
            if (!Auth::user()->perfil->administrador){
            	return redirect('/');
            }
            return $next($request);
        });
    }    

    public function index(){
    	$usuarios = User::get();

    	return view('usuario.usuario')->with(["usuarios"=>$usuarios]);
    }

    public function formCreate($perfil_id){
        $perfis = Perfil::find($perfil_id);

        if (!$perfis || $perfil_id == 1){
            $perfis = Perfil::whereRaw("id <> 1")->get();
        }
        else {
            $perfis = Perfil::whereRaw("id = {$perfil_id}")->get();
        }

    	return view('usuario.formCreate')->with(["perfis"=>$perfis]);    	
    }

    public function create(Request $request){
	    $this->validate($request, [
	        'nome' => 'required|max:255',
	        'sexo' => 'required|max:1',
	        'cpf' => 'required|unique:pessoa|max:11',
	        'email' => 'required|unique:pessoa',
	        'login' => 'required|unique:users',
	        'password' => 'required|confirmed|min:6',
	        'perfil_id' => 'required',
	    ]);

	    $data = $request->all();

		try{
			DB::beginTransaction();
			$pessoa = new Pessoa();
			$usuario = new User();
			
			$pessoa->nome = $data['nome'];
			$pessoa->sexo = $data['sexo'];

			if ($data['data_nascimento'] != "") $pessoa->data_nascimento = $data['data_nascimento'];
			if ($data['cpf'] != "") $pessoa->cpf = $data['cpf'];
			$pessoa->email = $data['email'];
			
			$pessoa->save();
			
			$usuario->login = $data['login'];
			$usuario->password = bcrypt($data['password']);

			$usuario->perfil()->associate(Perfil::find($data['perfil_id']));
			$usuario->pessoa()->associate($pessoa);

			$usuario->save();
			DB::commit();
		}
		catch (Exception $e){
			DB::rollback();
			throw $e;
		}

        return redirect('usuario'); 
    }

    public function formUpdate($usuario_id){
        $usuario = User::find($usuario_id);

       	return view('usuario.formUpdate')->with(["usuario"=>$usuario]);    	
    }

    public function update(Request $request){
	    $data = $request->all();

		$usuario = User::find($data['usuario_id']);
		$pessoa = $usuario->pessoa;

	    $this->validate($request, [
	        'nome' => 'required|max:255',
	        'cpf' => [
				Rule::unique('pessoa')->ignore($pessoa->id),
			  ],
	        'email' => [
				Rule::unique('pessoa')->ignore($pessoa->id),
			  ],
	        'login' => [
				Rule::unique('users')->ignore($usuario->id),
			  ],
	        'password' => 'confirmed|min:6',
	    ]);
        
		$pessoa->nome = $data['nome'];
        if (isset($data['sexo'])) $pessoa->sexo = $data['sexo'];
		$pessoa->data_nascimento = ($data['data_nascimento'] != "")? $data['data_nascimento']: null;
		$pessoa->cpf = ($data['cpf'] != "")? $data['cpf']: null;
        $pessoa->email = $data['email'];
		$pessoa->save();
        
		$usuario->login = $data['login'];
        if ($data['password'] != "") $usuario->password = bcrypt($data['password']);

        $usuario->save();       

        return redirect('/usuario'); 
    }
	
	public function delete($usuario_id){
		$usuario = User::find($usuario_id);
		$usuario->delete();
        return redirect('/usuario'); 
	}
}