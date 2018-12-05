<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class ToDoList extends Model
{
    const USER_ID       = 'user_id';
    const TITLE         = 'title';
    const TODO_LIST_ID  = 'list_id';

    protected $fillable = [self::USER_ID, self::TITLE];

    public function tasks()
    {
    	return $this->hasMany('\App\Task', self::TODO_LIST_ID);
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
