<?php 

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Area;

class AreaController extends Controller {
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
			$conteudo = Auth::user()->perfil->conteudos->where("rota", "/area")->first();
			        
			if ($conteudo == null){
                return redirect('/');
            }
			
			$this->permissoes = $conteudo->pivot;
			
            return $next($request);
        });
    }    

	public function index(){
		$areas = Area::get();
		return view('area.area')->with(['areas'=>$areas, 'permissoes'=>$this->permissoes]);
	}
	
	public function formCreate(){
		if ($this->permissoes->inserir){
			return view('area.formCreate');
		}
		else{
			return redirect('area');
		}
	}
	
	public function Create(Request $request){
		$params = $request->all();
		$area = new Area($params);
		$area->save();
		return redirect('/area')->withInput();
	}
	
	public function formUpdate($area_id){
		if ($this->permissoes->alterar){
			$area = Area::find($area_id);
			return view('area.formUpdate')->with('area', $area);
		}
		else{
			return redirect('/area');
		}
	}
	
	public function update(Request $request){
		$this->validate($request, [
	        'area' => 'required',
	    ]);

	    $data = $request->all();
		$area = Area::find($data['area_id']);
		$area->update($data);
		return redirect('/area');
	}
	
	public function delete($area_id){
		if ($this->permissoes->excluir){
			$area = Area::find($area_id);
			$area->delete();
		}
		return redirect('/area');
	}
}
