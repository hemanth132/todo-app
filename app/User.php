<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    protected $fillable = ['email','password'];

    protected $hidden = ['password'];

    public function todoLists(){
    	return $this->hasMany('\App\ToDoList');
    }
}
