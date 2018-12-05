<?php

namespace App\Http\Controllers;

use App\Fields;
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
        $this->authorize('update', $toDoList);
        return $toDoList->tasks;
    }

    public function store($toDoListId)
    {
        $toDoList = ToDoList::find($toDoListId);
        $this->authorize('update', $toDoList);

        request()->validate([
            Fields::DESCRIPTION => 'required'
        ]);

        $task = new Task();
        $task->{Task::DESCRIPTION} = request()->input(Fields::DESCRIPTION);
        $toDoList->tasks()->save($task);

        return $task;
    }

    public function update($toDoListId, $taskId){
        $task = Task::find($taskId);
        $this->authorize('update', $task);
        $this->authorize('matchesList', [$task, $toDoListId]);

        request()->validate([
            Fields::STATUS => 'required|in:'.implode(',', [config('constants.TASK_STATUS_COMPLETE'), config('constants.TASK_STATUS_INCOMPLETE')])
        ]);

        $task->update(request()->only([Fields::STATUS]));
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
