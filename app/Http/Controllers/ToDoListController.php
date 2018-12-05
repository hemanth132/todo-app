<?php

namespace App\Http\Controllers;

use App\Fields;
use App\Policies\ToDoListPolicy;
use App\Services\ToDoListService;
use App\ToDoList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ToDoListController extends Controller
{
    protected $toDoListService;

    public function __construct(ToDoListService $toDoListService)
    {
        $this->toDoListService = $toDoListService;
    }

    public function index()
    {
        $user = Auth::user();
        return $user->todoLists()->with('tasks')->get();
    }

    public function store(Request $request)
    {
        request()->validate([
            Fields::TITLE => 'required'
        ]);

        return $this->toDoListService->addNewToDoList();
    }

    public function show($id)
    {
        $toDoList = ToDoList::with('tasks')->find($id);
        $this->authorize('update',$toDoList);
        return $toDoList;
    }

    public function destroy($id)
    {
        $toDoList = ToDoList::find($id);
        $this->authorize('update',$toDoList);
        $toDoList->delete();

        return $toDoList;
    }
}
