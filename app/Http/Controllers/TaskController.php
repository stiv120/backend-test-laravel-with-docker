<?php

namespace App\Http\Controllers;

use ErrorException;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tasks = Task::query();
        if ($request->has('status')) {
            $tasks->where('status', $request->input('status'));
        }
        if ($request->has('due_date')) {
            $tasks->whereDate('due_date', $request->input('due_date'));
        }
        $tasks = $tasks->get();

        return response()->json($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        $task = Task::create($request->all());
        if (!$task) {
            throw new ErrorException('Failed to create the task in the database.');
        }
        return response()->json(['message' => 'Task created successfully.'], 201);
    }

    /**
     * Show the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::find($id);
        if (!$task) {
            throw new ErrorException('Task not found in the database.');
        }
        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::find($id);
        if (!$task) {
            throw new ErrorException('Task not found in the database.');
        }
        $updated = $task->update($request->all());
        if (!$updated) {
            throw new ErrorException('Failed to update the task in the database.');
        }
        return response()->json(['message' => 'Task updated successfully.'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::find($id);
        if (!$task) {
            throw new ErrorException('Task not found in the database.');
        }
        $deleted = $task->delete();
        if (!$deleted) {
            throw new ErrorException('Failed to delete the task in the database.');
        }
        return response()->json(['message' => 'Task deleted successfully.'], 200);
    }
}
