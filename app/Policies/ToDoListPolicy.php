<?php

namespace App\Policies;

use App\User;
use App\ToDoList;
use Illuminate\Auth\Access\HandlesAuthorization;

class ToDoListPolicy
{
    use HandlesAuthorization;

    public function update(User $user, ToDoList $toDoList)
    {
        if($toDoList == null){
            return false;
        }
        return $toDoList->user_id == $user->id;
    }
}
