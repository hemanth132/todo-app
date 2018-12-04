<?php

namespace App\Http\Controllers;

use App\Policies\ToDoListPolicy;
use App\ToDoList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ToDoListController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return $user->todoLists()->with('tasks')->get();
    }

    public function store(Request $request)
    {
        request()->validate([
            'title' => 'required'
        ]);

        $user = Auth::user();
        $title = $request->input('title');

        $todoList = new \App\ToDoList();
        $todoList->title = $title;
        $user->todoLists()->save($todoList);

        return $todoList;
    }

    public function show($id)
    {
        $toDoList = ToDoList::with('tasks')->find($id);
        $this->authorize('update',$toDoList);
        $toDoList->user;
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
