<?php

namespace App\Http\Controllers;

use App\Task;
use App\ToDoList;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index($toDoListId)
    {
        $toDoList = ToDoList::find($toDoListId);
        if($toDoList == null)
        {
            return null;
        }
        $this->authorize('update', $toDoList);
        return $toDoList->tasks;
    }

    public function store($toDoListId)
    {
        $toDoList = ToDoList::find($toDoListId);
        if($toDoList == null)
        {
            return null;
        }
        $this->authorize('update', $toDoList);
        request()->validate([
            'description' => 'required'
        ]);

        $task = new Task();
        $task->description = request()->input('description');
        $toDoList->tasks()->save($task);

        return $task;
    }

    public function update($toDoListId, $taskId){
        $task = Task::find($taskId);
        $this->authorize('update', $task);
        $this->authorize('matchesList', [$task, $toDoListId]);

        request()->validate([
            'status' => 'required'
        ]);
        $attributes = request()->only(['status']);

        $task->update($attributes);
        return $task;
    }

    public function destroy($toDoListId, $taskId)
    {
        $task = Task::find($taskId);
        $this->authorize('update', $task);
        $this->authorize('matchesList', [$task, $toDoListId]);
        $task->delete();

        return $task;
    }
}
