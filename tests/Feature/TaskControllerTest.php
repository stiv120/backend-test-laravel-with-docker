<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskControllerTest extends TestCase
{
    protected $user;
    protected $header;

    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user using factories
        $this->user = User::factory()->create();
        // Generate a JWT token for the user
        $token = JWTAuth::fromUser($this->user);

        $header = ['Authorization' => 'Bearer ' . $token];
        $this->header = $header;
    }

    /** @test */
    public function userCanAuthenticate()
    {
        $response = $this->withHeaders($this->header)->getJson('/api/user');
        $response->assertStatus(200);
    }

    /** @test */
    public function canListTasks()
    {
        // Authenticate the user for our API
        $this->actingAs($this->user, 'api');

        // Create some tasks to test the listing
        Task::factory()->count(5)->create();

        // Make the GET request to /api/tasks with the authorization headers
        $response = $this->withHeaders($this->header)->getJson('/api/tasks');

        // Verify that the response has a 200 status code
        $response->assertStatus(200);

        // Decode the JSON response into an associative array
        $tasks = $response->json();

        // Verify that the number of tasks received is 5
        $this->assertCount(5, $tasks);
    }

    /** @test */
    public function canCreateTask()
    {
        // Authenticate the user for our API
        $this->actingAs($this->user, 'api');

        // Task data to create
        $taskData = [
            'title' => 'New Task',
            'description' => 'Description of the new task',
            'status' => 'pending',
            'due_date' => '2024-07-10',
        ];

        // Make the POST request to /api/tasks to create the task
        $response = $this->withHeaders($this->header)->postJson('/api/tasks', $taskData);

        // Verify that the task was created successfully
        $response->assertStatus(201);
    }

    /** @test */
    public function canShowTask()
    {
        // Authenticate the user for our API
        $this->actingAs($this->user, 'api');

        // Create a task to test the show
        $task = Task::factory()->create();

        // Make the GET request to /api/tasks/{id} to show the task
        $response = $this->withHeaders($this->header)->getJson("/api/tasks/{$task->id}");

        // Verify that the request was successful and the task is correct
        $response->assertStatus(200);
    }

    /** @test */
    public function canUpdateTask()
    {
        // Authenticate the user for our API
        $this->actingAs($this->user, 'api');

        // Create a task to test the update
        $task = Task::factory()->create();

        // Updated task data
        $updatedData = [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'status' => 'completed',
            'due_date' => '2024-07-15',
        ];

        // Make the PUT request to /api/tasks/{id} to update the task
        $response = $this->withHeaders($this->header)->putJson("/api/tasks/{$task->id}", $updatedData);

        // Verify that the task was updated successfully
        $response->assertStatus(200);
    }

    /** @test */
    public function canDeleteTask()
    {
        // Authenticate the user for our API
        $this->actingAs($this->user, 'api');

        // Create a task to test the deletion
        $task = Task::factory()->create();

        // Make the DELETE request to /api/tasks/{id} to delete the task
        $response = $this->withHeaders($this->header)->deleteJson("/api/tasks/{$task->id}");

        // Verify that the task was deleted successfully
        $response->assertStatus(200);

        // Verify that the task no longer exists in the database
        $this->assertNull(Task::find($task->id));
    }
}
