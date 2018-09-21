<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Avaliador extends Model {

	protected $table = 'avaliador';

	protected $fillable = array('area','instituicao_id','pessoa_id');

	public $timestamps = false;

	public function instituicao(){
		return $this->belongsTo('App\Instituicao');
	}
	public function pessoa(){
		return $this->belongsTo('App\Pessoa');
	}
	public function avaliacoes(){
		return $this->hasMany('App\Avaliacao');
	}
//	public function avaliadorcategoria(){
//		return $this->hasMany('App\AvaliadorCategoria');
//	}
//	public function avaliador(){
//		return $this->hasMany('App\Avaliador');
//	}
//	public function area(){
//		return $this->hasMany('App\Area');
//	}
}
