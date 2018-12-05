<?php

namespace App\Policies;

use App\User;
use App\Task;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Task $task)
    {
        if($task == null){
            return false;
        }
        return $task->toDoList->user->id == $user->id;
    }

    public function matchesList(User $user, Task $task, $toDoListId){
        if($task == null){
            return false;
        }
        return $task->list_id == $toDoListId;
    }
}
