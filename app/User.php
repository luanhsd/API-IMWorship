<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','username','password','tel', 'email', 'type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','created_at','updated_at'
    ];

    public function rules($id = '')
    {
        return [
            'name'      => 'required | min: 3',
            'username'  => 'required | min: 3',
            'password'  => 'required | min:3',
            'email'     => "required | unique:users,email,{$id},id",
        ];
    }

    public function rulesSearch()
    {
        return[
            'key'   =>  'required'
        ];
    }

    public function rulesLogin()
    {
        return[
            'username'  => 'required | min: 3',
            'password'  => 'required | min:3',
        ];
    }

    
}
