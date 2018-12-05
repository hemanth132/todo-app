<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ToDoList;

class Task extends Model
{
    const TODO_LIST_ID  = 'list_id';
    const DESCRIPTION   = 'description';
    const STATUS        = 'status';

    protected $fillable = [self::TODO_LIST_ID, self::DESCRIPTION, self::STATUS];

    public function toDoList(){
    	return $this->belongsTo('\App\ToDoList', self::TODO_LIST_ID);
    }
}
