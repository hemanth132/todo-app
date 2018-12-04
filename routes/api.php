<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', function (Request $request) {
    return 'hello from api';
});

Route::post('/user', 'UserController@store');

// Route::apiResource('todolists', 'ToDoListController');

Route::resource('todolists', 'ToDoListController')->only(['index','store','show','destroy'])->middleware('auth:basic_auth');

Route::get('/todolists/{todolist}/tasks', 'TaskController@index')->middleware('auth:basic_auth');;
Route::post('/todolists/{todolist}/tasks', 'TaskController@store')->middleware('auth:basic_auth');;
Route::delete('/todolists/{todolist}/tasks/{taskId}', 'TaskController@destroy')->middleware('auth:basic_auth');;
Route::patch('/todolists/{todolist}/tasks/{taskId}', 'TaskController@update')->middleware('auth:basic_auth');;