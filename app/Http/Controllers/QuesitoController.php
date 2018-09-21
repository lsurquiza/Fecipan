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
use App\Evento;
use App\Quesito;

class QuesitoController extends Controller {
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
			$conteudo = Auth::user()->perfil->conteudos->where("rota", "/quesito")->first();
			        
			if ($conteudo == null){
                return redirect('/');
            }
			
			$this->permissoes = $conteudo->pivot;
			
            return $next($request);
        });
    }    

	public function index($evento_id){
		$evento = Evento::find($evento_id);
		return view('quesito.quesito')->with(['evento'=>$evento, 'permissoes'=>$this->permissoes]);
	}

	public function formCreate($evento_id){
		if ($this->permissoes->inserir){
			return view('quesito.formCreate')->with(["evento"=>Evento::find($evento_id)]);
		}else{
			return redirect('/quesito');
		}
	}
	
	public function create(Request $request){
		if ($this->permissoes->inserir){
			$this->validate($request, [
				'enunciado' => 'required',
				'peso' => 'required',
				'evento_id' => 'required',
			]);
			$params = $request->all();
			
			$quesito = new Quesito();
			$quesito->enunciado = $params['enunciado'];
			$quesito->peso = $params['peso'];
			$quesito->evento()->associate(Evento::find($params['evento_id']));
			$quesito->save();
		}
		return redirect("/evento/quesitos/{$params['evento_id']}");
	}

	public function delete($quesito_id){
		if ($this->permissoes['excluir']){
			$quesito = Quesito::find($quesito_id);
			$evento_id = $quesito['evento_id'];
			$quesito->delete();
		}
		return redirect("/evento/quesitos/{$evento_id}");
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
