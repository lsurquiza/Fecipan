<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    protected $table="users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login', 'password', 'ativo', 'created_at', 'updated_up', 'remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     *  Define o campo de login do sistema (o default é usar o campo email)
     *
     */
    public function username(){
        return 'login';
    }


    /**
     *  
     *
     */
    public function pessoa(){
        return $this->belongsTo('App\Pessoa');
    }    

    /**
     *  
     *
     */
    public function perfil(){
        return $this->belongsTo('App\Perfil');
    }    
}
