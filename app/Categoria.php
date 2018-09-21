<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model {

	protected $table = 'categoria';

	protected $fillable = array('descricao');

	public $timestamps = false;
	
	public function trabalho(){
   		return $this->hasMany('App\Trabalho');
  	}
  	public function estudante(){
  		return $this->hasMany('App\Estudante');
  	}
  	public function avaliadorcategoria(){
  		return $this->hasMany('App\AvaliadorCategoria');
  	}
}
