<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trabalho extends Model {

	protected $table = 'trabalho';
	
	protected $fillable = array('titulo', 'cod', 'maquete', 'area_id', 'tipo_trabalho_id', 'categoria_id', 'evento_id');

	public $timestamps = false;
	
  	public function evento(){
  		return $this->belongsTo('App\Evento');
  	}

	public function tipoTrabalho(){
			return $this->belongsTo('App\TipoTrabalho');
	}

	public function categoria(){
  			return $this->belongsTo('App\Categoria');
  	}

  	public function area(){
  			return $this->belongsTo('App\Area');
  	}

  	public function avaliacoes(){
  			return $this->hasMany('App\Avaliacao');
  	}
	
	public function notas(){
        return $this->hasManyThrough('App\Nota', 'App\Avaliacao');
    }

  	public function orientadores(){
  			return $this->belongsToMany('App\Orientador', 'orientacao')->withPivot('tipo_orientacao');
  	}

  	public function estudantes(){
  			return $this->belongsToMany('App\Estudante', 'participacao');
  	}
}
