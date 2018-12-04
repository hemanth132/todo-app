<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ToDoList;

class Task extends Model
{
    protected $fillable = ['list_id','description','status'];

    public function toDoList(){
    	return $this->belongsTo('\App\ToDoList', 'list_id');
    }
}
