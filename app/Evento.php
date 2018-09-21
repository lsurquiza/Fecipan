<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model {

	protected $table = 'evento';

	protected $fillable = array('titulo','ano','semestre','tema','cidade','data_inicio','data_fim', 'ativo');

	public $timestamps = false;

	public function trabalhos(){
   		return $this->hasMany('App\Trabalho');
  	}
	
	public function quesitos(){
		return $this->hasMany('App\Quesito');
	}
}
