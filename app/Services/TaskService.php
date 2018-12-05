<?php 

namespace App\Services;

use App\Fields;
use App\Task;
use App\ToDoList;

class TaskService
{
    public function addTaskToList(ToDoList $toDoList)
    {
        $task = new Task();
        $task->{Task::DESCRIPTION} = request()->input(Fields::DESCRIPTION);
        $toDoList->tasks()->save($task);

        return $task;
    }

    public function updateTaskStatus($task)
    {
        $task->update(request()->only([Fields::STATUS]));

        return $task;
    }
}