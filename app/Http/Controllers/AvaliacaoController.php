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
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Trabalho;
use App\Avaliacao;
use App\Avaliador;
use App\Nota;
use App\Quesito;

class AvaliacaoController extends Controller {
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
			$conteudo = Auth::user()->perfil->conteudos->where("rota", "/avaliacao")->first();
			        
			if ($conteudo == null){
                return redirect('/');
            }
			
			$this->permissoes = $conteudo->pivot;
			
            return $next($request);
        });
    }    

	public function index($trabalho_id){
		$trabalho = Trabalho::find($trabalho_id);
		return view('avaliacao.avaliacao')->with(['trabalho'=>$trabalho, 'permissoes'=>$this->permissoes]);
	}

	public function formCreate($trabalho_id){
		$trabalho = Trabalho::find($trabalho_id);
		
		//$avaliadores = Avaliador::->whereNotIn('id', )get();
		
		$avaliadores_cadastrados = array();
		foreach ($trabalho->avaliacoes as $avaliacao){
			$avaliadores_cadastrados[] = $avaliacao->avaliador_id;
		}
		
		$avaliadores = Avaliador::whereNotIn('id', $avaliadores_cadastrados)->get();
		
		if ($this->permissoes->inserir){
			return view('avaliacao.formCreate')->with(["avaliadores"=>$avaliadores, "trabalho"=>$trabalho]);
		}else{
			return redirect("/trabalho/avaliacoes/{$trabalho_id}");
		}
	}
	
	public function create(Request $request){
		if ($this->permissoes->inserir){
			$this->validate($request, [
				'avaliadores' => 'required',
			]);
			$params = $request->all();
			
			foreach ($params["avaliadores"] as $avaliador_id){
				try{
					DB::beginTransaction();
					$avaliacao = new Avaliacao();
					$avaliacao->avaliador()->associate($avaliador_id);
					$avaliacao->trabalho()->associate($params["trabalho_id"]);
					$avaliacao->notas_lancadas = false;
					$avaliacao->save();
					
					$trabalho = Trabalho::find($params["trabalho_id"]);
					
					foreach($trabalho->evento->quesitos as $quesito){
						$nota = new Nota();
						$nota->avaliacao()->associate($avaliacao->id);
						$nota->quesito()->associate($quesito->id);
						$nota->save();
					}
					DB::commit();
				}
				catch (Exception $e){
					DB::rollback();
					throw $e;
				}
			}
		}
		return redirect("/trabalho/avaliacoes/{$params['trabalho_id']}");
	}

	public function delete($avaliacao_id){
		# Ao excluir uma avaliação, as notas são excluídas
		#	em cascata (ON DELETE CASCADE no BD)
		if ($this->permissoes['excluir']){
			$avaliacao = Avaliacao::find($avaliacao_id);
			$trabalho_id = $avaliacao['trabalho_id'];
			$avaliacao->delete();
		}
		return redirect("/trabalho/avaliacoes/{$trabalho_id}");
	}
	
	public function formNotas($avaliacao_id){
		$avaliacao = Avaliacao::find($avaliacao_id);
		
		return view('avaliacao.notas')->with(['avaliacao'=>$avaliacao, 'permissoes'=>$this->permissoes]);
	}

	public function updateNotas(Request $request){
		if ($this->permissoes->inserir){
			$this->validate($request, [
				'avaliacao_id' => 'required',
				'notas' => 'required',
			]);
			$params = $request->all();
			
			$avaliacao = Avaliacao::find($params['avaliacao_id']);
			
			DB::beginTransaction();
			try{
				foreach($params['notas'] as $id => $valor){
					$nota = Nota::find($id);
					$nota->valor = $valor;
					$nota->save();
				}
		
				$avaliacao->notas_lancadas = true;
				$avaliacao->save();
				DB::commit();
			}
			catch(Exception $e){
				DB::rollback();
				throw $e;
			}
		}
		return redirect("/trabalho/avaliacoes/{$avaliacao->trabalho_id}");
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
