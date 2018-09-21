<?php 

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TipoTrabalhoRequest;
use App\TipoTrabalho;

class TipoTrabalhoController extends Controller {
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
			$conteudo = Auth::user()->perfil->conteudos->where("rota", "/tipoTrabalho")->first();
			        
			if ($conteudo == null){
                return redirect('/');
            }
			
			$this->permissoes = $conteudo->pivot;
			
            return $next($request);
        });
    }    
	
	public function index(){
		$tiposTrabalho = TipoTrabalho::get();
		return view('tipotrabalho.tipotrabalho')->with(['tiposTrabalho'=>$tiposTrabalho, 'permissoes'=>$this->permissoes]);
	}
	
	public function formCreate(){
		if ($this->permissoes->inserir){
			return view('tipotrabalho.formCreate');
		}else{
			return redirect('/tipoTrabalho');
		}
	}
	
	public function create(Request $request){
		$params = $request->all();
		$tipotrabalho = new TipoTrabalho($params);
		$tipotrabalho->save();
		return redirect('/tipoTrabalho');
	}
	
	public function formUpdate($tipoTrabalho_id){
		if ($this->permissoes->alterar){
			$tipoTrabalho = TipoTrabalho::find($tipoTrabalho_id);
			return view('tipotrabalho.formUpdate')->with('tipoTrabalho',$tipoTrabalho);			
		}
		else{
			return redirect ('/tipoTrabalho');
		}
	}
	
	public function update(Request $request){
		$params = $request->all();
		$tipotrabalho = TipoTrabalho::find($params["id"]);
		$tipotrabalho->update($params);
		return redirect('/tipoTrabalho');
	}
	
	public function delete($tipoTrabalho_id){
		if ($this->permissoes->excluir){
			$tipotrabalho = TipoTrabalho::find($tipoTrabalho_id);
			$tipotrabalho->delete();
		}
		return redirect('/tipoTrabalho');
	}
}
