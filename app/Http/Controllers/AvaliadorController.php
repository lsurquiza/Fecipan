<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Pessoa;
use App\Instituicao;
use App\Avaliador;
use App\User;

class AvaliadorController extends Controller{
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
			$conteudo = Auth::user()->perfil->conteudos->where("rota", "/pessoa/avaliadores")->first();

			if (!Auth::user()->perfil->administrador && $conteudo == null){
                return redirect('/');
            }

			$this->permissoes = $conteudo? $conteudo->pivot: null;

            return $next($request);
        });
    }    

    public function index(){
		if (Auth::user()->perfil->administrador || $this->permissoes->visualizar){
			$avaliadores = Avaliador::get();
			return view('avaliador.avaliador')->with(["avaliadores"=>$avaliadores]);
		}
		return redirect('/home');
    }

    public function avaliacoes($avaliador_id){
		if (Auth::user()->perfil->administrador || $this->permissoes->visualizar){
			$avaliador = Avaliador::find($avaliador_id);
			return view('avaliador.avaliacoes')->with(["avaliador"=>$avaliador]);
		}
		return redirect('/home');
    }

    public function formCreate(){
		if (Auth::user()->perfil->administrador || $this->permissoes->inserir){
			$instituicoes = Instituicao::get();
			return view('avaliador.formCreate')->with(["instituicoes"=>$instituicoes]);
		}
		return redirect('/pessoa/avaliadores');
    }

    public function create(Request $request){
		if (Auth::user()->perfil->administrador || $this->permissoes->inserir){
			$this->validate($request, [
				'instituicao_id' => 'required',
				'nome' => 'required|max:255',
				'cpf' => 'unique:pessoa|max:11',
				'email' => 'unique:pessoa',
			]);

			$data = $request->all();
			
			$pessoa = new Pessoa();
			$avaliador = new Avaliador();
			
			$pessoa->nome = $data['nome'];

			if (isset($data['sexo'])) $pessoa->sexo = $data['sexo'];
			if ($data['data_nascimento'] != "") $pessoa->data_nascimento = $data['data_nascimento'];
			if ($data['cpf'] != "") $pessoa->cpf = $data['cpf'];
			if ($data['email'] != "") $pessoa->email = $data['email'];
			
			$pessoa->save();
			
			$avaliador->area = $data['area'];

			$avaliador->pessoa()->associate($pessoa);
			$avaliador->instituicao()->associate(Instituicao::find($data["instituicao_id"]));

			$avaliador->save();       
		}
    	return redirect('/pessoa/avaliadores');
    }
	
	public function delete($avaliador_id){
		if (Auth::user()->perfil->administrador || $this->permissoes->excluir){
			$avaliador = Avaliador::find($avaliador_id);
			$pessoa = $avaliador->pessoa();
			
			$avaliador->delete();
			$pessoa->delete();
		}
    	return redirect('/pessoa/avaliadores');
	}
}
