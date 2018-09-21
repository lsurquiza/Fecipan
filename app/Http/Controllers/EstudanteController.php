<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Pessoa;
use App\Estudante;
use App\Instituicao;
use App\Categoria;
use App\User;

class EstudanteController extends Controller{
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
			$conteudo = Auth::user()->perfil->conteudos->where("rota", "/pessoa/estudantes")->first();

            if (!Auth::user()->perfil->administrador && $conteudo == null){
                return redirect('/');
            }

			$this->permissoes = $conteudo? $conteudo->pivot: null;
			
            return $next($request);
        });
    }    

    public function index(){
		if (Auth::user()->perfil->administrador || $this->permissoes->inserir){
			$estudantes = Estudante::get();
			return view('estudante.estudante')->with(["estudantes"=>$estudantes]);
		}
		return redirect('/home');
    }

    public function trabalhos($estudante_id){
		if (Auth::user()->perfil->administrador || $this->permissoes->visualizar){
			$estudante = Estudante::find($estudante_id);
			return view('estudante.trabalhos')->with(["estudante"=>$estudante]);
		}
		return redirect('/home');
    }

    public function formCreate(){
		if (Auth::user()->perfil->administrador || $this->permissoes->inserir){
			$instituicoes = Instituicao::get();
			$categorias = Categoria::get();
			return view('estudante.formCreate')->with(["instituicoes"=>$instituicoes, "categorias"=>$categorias]);
		}
		return redirect('/pessoa/estudantes');
    }

    public function create(Request $request){
		if (Auth::user()->perfil->administrador || $this->permissoes->visualizar){
			$this->validate($request, [
				'instituicao_id' => 'required',
				'categoria_id' => 'required',
				'nome' => 'required|max:255',
				'cpf' => 'unique:pessoa|max:11',
				'email' => 'unique:pessoa',
			]);

			$data = $request->all();
			
			$pessoa = new Pessoa();
			$estudante = new Estudante();
			
			$pessoa->nome = $data['nome'];

			if (isset($data['sexo'])) $pessoa->sexo = $data['sexo'];
			if ($data['data_nascimento'] != "") $pessoa->data_nascimento = $data['data_nascimento'];
			if ($data['cpf'] != "") $pessoa->cpf = $data['cpf'];
			if ($data['email'] != "") $pessoa->email = $data['email'];
			
			$pessoa->save();
			
			$estudante->ra = $data['ra'];

			$estudante->pessoa()->associate($pessoa);
			$estudante->categoria()->associate(Categoria::find($data["categoria_id"]));
			$estudante->instituicao()->associate(Instituicao::find($data["instituicao_id"]));

			$estudante->save();       
		}
    	return redirect('/pessoa/estudantes');
    }
	
	public function delete($estudante_id){
		if (Auth::user()->perfil->administrador || $this->permissoes->excluir){
			$estudante = Estudante::find($estudante_id);
			$pessoa = $estudante->pessoa();
			
			$estudante->delete();
			$pessoa->delete();
		}
    	return redirect('/pessoa/estudantes');
	}
}
