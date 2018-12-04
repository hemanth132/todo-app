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
        return $toDoList->user_id == $user->id;
    }
}
