<?php

namespace App\Http\Controllers;

use App\Fields;
use App\Services\TaskService;
use App\Task;
use App\ToDoList;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

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

        return $this->taskService->addTaskToList($toDoList);
    }

    public function update($toDoListId, $taskId){
        $task = Task::find($taskId);
        $this->authorize('update', $task);
        $this->authorize('matchesList', [$task, $toDoListId]);

        request()->validate([
            Fields::STATUS => 'required|in:'.implode(',', [config('constants.TASK_STATUS_COMPLETE'), config('constants.TASK_STATUS_INCOMPLETE')])
        ]);

        return $this->taskService->updateTaskStatus($task);
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
