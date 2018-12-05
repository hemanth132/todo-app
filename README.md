# ToDo-App

Requirements:
1. There can be multiple users in the system. Each user has to register with the system using email and password. Only registered users can add to do lists.
2. Each user can have multiple todo lists and each list can have a name.
3. Each list can have multiple tasks where each task contains the task description. Each task can be marked as complete/incomplete.

List of API:

GET | api/todolists -- get all tolists for a user
POST     | api/todolists -- add new todo list for a user
GET | api/todolists/{todolist} -- get a particular todolist
DELETE   | api/todolists/{todolist} -- remove a particulat todolist
POST     | api/todolists/{todolist}/tasks -- add a new task to a given todo list
GET | api/todolists/{todolist}/tasks -- get all tasks for a given todolist
PATCH    | api/todolists/{todolist}/tasks/{taskId} -- mark as complete/incokplete for a given task
DELETE   | api/todolists/{todolist}/tasks/{taskId} -- delete a task
POST     | api/user -- add a new user