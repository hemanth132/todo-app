<?php 

namespace App\Services;

use App\Fields;
use App\ToDoList;
use Illuminate\Support\Facades\Auth;

class ToDoListService
{
    public function addNewToDoList()
    {
        $user = Auth::user();

        $todoList = new ToDoList();
        $todoList->{ToDoList::TITLE} = request()->input(Fields::TITLE);
        $user->todoLists()->save($todoList);

        return $todoList;
    }

}