<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model {

	protected $table = 'area';

	protected $fillable = array('sigla', 'area');

	public $timestamps = false;
	
	public function trabalho(){
		return $this->hasMany('App\Trabalho');
	}
	
	public function avaliadores(){
		return $this->belongsToMany('App\Avaliador', 'avaliador_area', 'area_id', 'avaliador_id');
	}
}
