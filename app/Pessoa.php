<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    protected $table = "pessoa";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome', 'sexo', 'cpf', 'data_nascimento', 'email', 'telefone1', 'telefone2'
    ];

     /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
	
    public function usuarios(){
    	 return $this->hasMany('App\User');
    }
}
