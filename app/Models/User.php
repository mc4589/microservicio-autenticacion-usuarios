<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
    {
        use HasApiTokens, Notifiable;
        /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nombre',     
        'email',
        'password',
        'perfil',
    ];
      /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
        /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'password' => 'hashed',
    ];
    }

   
