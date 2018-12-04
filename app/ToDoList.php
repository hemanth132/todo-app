<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class ToDoList extends Model
{
    protected $fillable = ['user_id','title'];

    public function tasks()
    {
    	return $this->hasMany('\App\Task','list_id');
    }

    public function isOwnedBy(User $user)
    {
    	if($this->user_id == $user->id){
    		return true;
    	}
    	return false;
    }

    public function user()
    {
    	return $this->belongsTo('\App\User');
    }
}
