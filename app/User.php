<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    const EMAIL     = 'email';
    const PASSWORD  = 'password';

    protected $fillable = [self::EMAIL, self::PASSWORD];

    protected $hidden = [self::PASSWORD];

    public function todoLists(){
    	return $this->hasMany('\App\ToDoList');
    }
}
