<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Pessoa;
use App\Instituicao;
use App\Orientador;
use App\User;

class OrientadorController extends Controller{
	private $permissoes;
	
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
			$conteudo = Auth::user()->perfil->conteudos->where("rota", "/pessoa/orientadores")->first();

			if (!Auth::user()->perfil->administrador && $conteudo == null){
                return redirect('/');
            }
			
			$this->permissoes = $conteudo? $conteudo->pivot: null;

            return $next($request);
        });
    }    

    public function index(){
		if (Auth::user()->perfil->administrador || $this->permissoes->visualizar){
			$orientadores = Orientador::get();
			return view('orientador.orientador')->with(["orientadores"=>$orientadores]);
		}
		return redirect('/home');
    }

    public function trabalhos($orientador_id){
		if (Auth::user()->perfil->administrador || $this->permissoes->visualizar){
			$orientador = Orientador::find($orientador_id);
			return view('orientador.trabalhos')->with(["orientador"=>$orientador]);
		}
		return redirect('/home');
    }
	
    public function formCreate(){
		if (Auth::user()->perfil->administrador || $this->permissoes->inserir){
			$instituicoes = Instituicao::get();
			return view('orientador.formCreate')->with(["instituicoes"=>$instituicoes]);
		}
		return redirect('/pessoa/orientadores');
    }

    public function create(Request $request){
		if (Auth::user()->perfil->administrador || $this->permissoes->visualizar){
			$this->validate($request, [
				'instituicao_id' => 'required',
				'nome' => 'required|max:255',
				'cpf' => 'unique:pessoa|max:11',
				'email' => 'unique:pessoa',
			]);

			$data = $request->all();
			
			$pessoa = new Pessoa();
			$orientador = new Orientador();
			
			$pessoa->nome = $data['nome'];

			if (isset($data['sexo'])) $pessoa->sexo = $data['sexo'];
			if ($data['data_nascimento'] != "") $pessoa->data_nascimento = $data['data_nascimento'];
			if ($data['cpf'] != "") $pessoa->cpf = $data['cpf'];
			if ($data['email'] != "") $pessoa->email = $data['email'];
			
			$pessoa->save();
			
			$orientador->pessoa()->associate($pessoa);
			$orientador->instituicao()->associate(Instituicao::find($data["instituicao_id"]));

			$orientador->save();       
		}
    	return redirect('/pessoa/orientadores');
    }
	
	public function delete($orientador_id){
		if (Auth::user()->perfil->administrador || $this->permissoes->excluir){
			$orientador = Orientador::find($orientador_id);
			$pessoa = $orientador->pessoa();
			
			$orientador->delete();
			$pessoa->delete();
		}
    	return redirect('/pessoa/orientadores');
	}
}