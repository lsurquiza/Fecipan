<?php

namespace App\Http\Controllers;

use App\Evento;
use App\Area;
use App\Categoria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
/*use fecipan\Http\Controllers\Controller;
use fecipan\Http\Requests\EventoRequest;
use Request;
*/
class EventoController extends Controller {
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
			$conteudo = Auth::user()->perfil->conteudos->where("rota", "/evento")->first();
			        
			if ($conteudo == null){
                return redirect('/');
            }
			
			$this->permissoes = $conteudo->pivot;
			
            return $next($request);
        });
    }    

	// A função index é executada para a rota /evento
	public function index(){
		$eventos = Evento::orderBy('id')->get();
				
		return view('evento.evento')->with(['eventos'=>$eventos, 'permissoes'=>$this->permissoes]);
	}
	
	public function formCreate(){
		if ($this->permissoes->inserir){
			return view('evento.formCreate');
		}
		else{
			return redirect('evento');
		}
	}
	
	public function create(Request $request){
		if ($this->permissoes->inserir){
			$this->validate($request, [
				'titulo' => 'required',
				'ano' => 'required',
				'semestre' => 'required',
				'tema' => 'required',
			]);

			$data = $request->all();
			$evento = new Evento($data);
			$evento->ativo = true;
			$evento->save();    	
		}
        return redirect('evento'); 
	}

	public function formUpdate($evento_id){
		if ($this->permissoes->alterar){
			return view ('evento.formUpdate')->with('e', Evento::find($evento_id));
		}
		else{
			return redirect('evento');
		}

	}
	public function update(Request $request){
		if ($this->permissoes->alterar){
			$this->validate($request, [
				'titulo' => 'required',
				'ano' => 'required',
				'semestre' => 'required',
				'tema' => 'required',
			]);

			$data = $request->all();

			$evento = Evento::find($data["evento_id"]);
			$evento->update($data);
		}
		return redirect('/evento');
//		return redirect()->action('EventoController@evento',['pagina' => 1])->with('titulo',$params['titulo']);
	}
	public function delete($evento_id){
		if ($this->permissoes->excluir){
			$evento = Evento::find($evento_id);
			$evento->delete();
		}
		return redirect('/evento');
	}
	
	public function ranking($evento_id){
		$evento = Evento::find($evento_id);
		$areas = Area::get();
		$categorias = Categoria::get();
		return view("evento.ranking")->with(["evento"=>$evento, "categorias"=>$categorias, "areas"=>$areas, "permissoes"=>$this->permissoes]);
	}
}
