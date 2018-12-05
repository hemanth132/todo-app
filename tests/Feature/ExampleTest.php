<?php

namespace Tests\Feature;

use App\Fields;
use App\Task;
use App\ToDoList;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function testAddingTodoList()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user,'basic_auth')->call('POST','/api/todolists', [Fields::TITLE => 'groceries']);
        $response->assertStatus(201);
        $response->assertJson(['user_id' => $user->id]);
        return $user;
    }

    /**
    * @depends testAddingTodoList
    **/
    public function testForbiddenAccessWhenGettingTodoList($user)
    {
        $newUser = factory(User::class)->create();
        $listId = $user->todoLists->first()->id;
        $response = $this->actingAs($newUser,'basic_auth')->call('GET','/api/todolists/'.$listId);
        $response->assertStatus(403);
    }

    /**
    * @depends testAddingTodoList
    **/
    public function testUnauthorizedAccessWhenGettingTodoList($user)
    {
        $listId = $user->todoLists->first()->id;
        $response = $this->call('GET','/api/todolists/'.$listId);
        $response->assertStatus(401);
    }

    /**
    * @depends testAddingTodoList
    **/
    public function testAddingTask($user)
    {
        $listId = $user->todoLists->first()->id;
        $url = '/api/todolists/'.$listId.'/tasks';
        $response = $this->actingAs($user,'basic_auth')->call('POST',$url, [Fields::DESCRIPTION => 'description']);
        $response->assertStatus(201);
        $response->assertJson(['list_id' => $listId]);

        return $user;
    }

    /**
    * @depends testAddingTask
    **/
    public function testUpdateTask($user)
    {
        $listId = $user->todoLists->first()->id;
        $taskId = $user->todoLists->first()->tasks->first()->id;
        $response = $this->actingAs($user,'basic_auth')->call('PATCH','/api/todolists/'.$listId.'/tasks/'.$taskId, [Fields::STATUS => config('constants.TASK_STATUS_COMPLETE')]);
        $response->assertStatus(200);
        $response->assertJson([Task::STATUS => config('constants.TASK_STATUS_COMPLETE')]);

        return $user;
    }

    /**
    * @depends testUpdateTask
    **/
    public function testGettingTodoLists($user)
    {
        $response = $this->actingAs($user,'basic_auth')->call('GET','/api/todolists');
        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonCount(1, '0.tasks');

        return $user;
    }

    /**
    * @depends testGettingTodoLists
    **/
    public function testDeleteTask($user)
    {
        $listId = $user->todoLists->first()->id;
        $taskId = $user->todoLists->first()->tasks->first()->id;

        $response = $this->actingAs($user,'basic_auth')->call('DELETE','/api/todolists/'.$listId.'/tasks/'.$taskId);
        $response->assertStatus(200);
        $response->assertJson([Task::STATUS => config('constants.TASK_STATUS_COMPLETE')]);

        return $user;
    }

    /**
    * @depends testDeleteTask
    **/
    public function testDeleteTodoList($user)
    {
        $listId = $user->todoLists->first()->id;

        $response = $this->actingAs($user,'basic_auth')->call('DELETE','/api/todolists/'.$listId);
        $response->assertStatus(200);
        $response->assertJson(['id' => $listId, ToDoList::USER_ID => $user->id]);

        return $user;
    }

    
}
