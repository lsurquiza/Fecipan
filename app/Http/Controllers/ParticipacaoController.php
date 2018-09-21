<?php

namespace App\Http\Controllers;

//use fecipan\Area;
//use fecipan\Categoria;
//use fecipan\Evento;
//use fecipan\Http\Controllers\Controller;
//use fecipan\Http\Requests\TrabalhoRequest;
//use fecipan\TipoTrabalho;
//use fecipan\Trabalho;
//use Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Trabalho;
use App\Participacao;
use App\Estudante;

class ParticipacaoController extends Controller {
	private $permissoes;

    public function __construct()
    {
		
        /**
         *  O sistema verifica primeiramente se o usuário está logado. 
		 *		Caso não esteja, 
         *      ele é direcionado para a tela de login. 
		 *
		 *		Caso o usuário esteja logado, o sistema
         *      verifica se ele tem perfil para acessar este controller. 
		 *
		 *		Caso não tenha, ele é redirecionado
         *      para a tela inicial do sistema
         *
         */
        $this->middleware(function($request, $next){
            if (Auth::check() == false){
                return redirect('/login');
            }
			$conteudo = Auth::user()->perfil->conteudos->where("rota", "/participacao")->first();
			        
			if ($conteudo == null){
                return redirect('/');
            }
			
			$this->permissoes = $conteudo->pivot;
			
            return $next($request);
        });
    }    

	public function index($trabalho_id){
		$trabalho = Trabalho::find($trabalho_id);
		return view('participacao.participacao')->with(['trabalho'=>$trabalho, 'permissoes'=>$this->permissoes]);
	}

	public function formCreate($trabalho_id){
		$trabalho = Trabalho::find($trabalho_id);
		
		$estudantes_cadastrados = array();
		foreach ($trabalho->estudantes as $estudante){
			$estudantes_cadastrados[] = $estudante->id;
		}
		
		$estudantes = Estudante::whereNotIn('id', $estudantes_cadastrados)->get();
		
		if ($this->permissoes->inserir){
			return view('participacao.formCreate')->with(["estudantes"=>$estudantes, "trabalho"=>$trabalho]);
		}else{
			return redirect("/trabalho/estudantes/{$trabalho_id}");
		}
	}
	
	public function create(Request $request){
		if ($this->permissoes->inserir){
			$this->validate($request, [
				'estudantes' => 'required',
			]);
			$params = $request->all();
			
			foreach($params["estudantes"] as $estudante_id){
				$trabalho = Trabalho::find($params['trabalho_id']);
				$estudante = Estudante::find($estudante_id);
				
				$trabalho->estudantes()->attach($estudante);
			}
		}
		return redirect("/trabalho/estudantes/{$params['trabalho_id']}");
	}

	public function delete($trabalho_id, $estudante_id){
		# Ao excluir uma avaliação, as notas são excluídas
		#	em cascata (ON DELETE CASCADE no BD)
		if ($this->permissoes['excluir']){
			$trabalho = Trabalho::find($trabalho_id);
			$trabalho_id = $trabalho->id;
			$trabalho->estudantes()->detach($estudante_id);
		}
		return redirect("/trabalho/estudantes/{$trabalho_id}");
	}
/*	
	public function trabalho(){
		$trabalho = Trabalho::orderBy('id')->get();
		return view('trabalho.trabalho')->with('trabalho',$trabalho);
	}
	
	public function form_trabalho(){
		return view ('trabalho.formtrabalho')->with('categorias', Categoria::orderBy('id')->get())->with('evento', Evento::orderBy('id')->get())->with('tipotrabalho', TipoTrabalho::orderBy('id')->get())->with('area', Area::orderBy('id')->get());
	}
	public function cadastrartrabalho(TrabalhoRequest $request){
		$params = $request->all();
		$trabalho = new Trabalho($params);
		$trabalho->save();
		return redirect('/trabalho')->withInput();
	}
	public function formeditartrabalho($id){
		$trabalho = Trabalho::find($id);
		return view ('trabalho.formeditartrabalho')->with('t', $trabalho)->with('evento', Evento::orderBy('id')->get())->with('categorias', Categoria::orderBy('id')->get())->with('tipotrabalho', TipoTrabalho::orderBy('id')->get())->with('area', Area::orderBy('id')->get());
	}
	public function editartrabalho(TrabalhoRequest $request, $id){
		$trabalho = Trabalho::find($id);
		$params = Request::all();
		$trabalho->update($params);
		return redirect('/trabalho');
	}
	public function deletartrabalho($id){
		$trabalho = Trabalho::find($id);
		$titulo = $trabalho['nome'];
		$trabalho->delete();
		return redirect('/trabalho')->with('deletartrabalho', $titulo);
	}
*/
}
