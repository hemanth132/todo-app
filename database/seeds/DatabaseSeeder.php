<?php

use App\Task;
use App\ToDoList;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 10)->create()->each(function($user){
            factory(ToDoList::class, 2)->create(['user_id' => $user->id])->each(function($toDoList){
                factory(Task::class, 3)->create(['list_id' => $toDoList->id]);
            });
        });

    }
}
