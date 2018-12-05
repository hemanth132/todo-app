<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function testAddingTodoList()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user,'basic_auth')->call('POST','/api/todolists', ['title' => 'groceries']);
        $response->assertStatus(201);
        $response->assertJson(['user_id' => $user->id]);
        return $user;
    }

    /**
    * @depends testAddingTodoList
    **/
    public function testAddingTask($user)
    {
        $listId = $user->todoLists->first()->id;
        $url = '/api/todolists/'.$listId.'/tasks';
        $response = $this->actingAs($user,'basic_auth')->call('POST',$url, ['description' => 'description']);
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
        $response = $this->actingAs($user,'basic_auth')->call('PATCH','/api/todolists/'.$listId.'/tasks/'.$taskId, ['status' => 'complete']);
        $response->assertStatus(200);
        $response->assertJson(['status' => 'complete']);

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
        $response->assertJson(['status' => 'complete']);

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
        $response->assertJson(['id' => $listId, 'user_id' => $user->id]);

        return $user;
    }

    
}
