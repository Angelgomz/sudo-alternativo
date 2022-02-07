<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Evento extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'eventos';
    protected $fillable = [
        'id', 
        'id_google',
        'nombre',
        'tipo_evento',
        'eTag',
        'description',
        'update_google',
        'created_by',
        'email_creator',
        'fecha',
        'begin',
        'end',
        'created_por',
        'status',
        'isActive'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
  
}
